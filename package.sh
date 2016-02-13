#!/bin/bash
RELEASE=false
INFOFILE="style.css"
PKGNAME="subarrum"
SCRIPTFOLDERS="js"
CSSFOLDERS="css"

for ARG in $*
do
    case $ARG in
        --release) RELEASE=true;;
    esac
done

# Find all script files
for FOLDER in $SCRIPTFOLDERS
do
    SCRIPTS=`find $FOLDER -name *.js -not -name *.min.js -type f -printf '%p '`
done

# If this is a release, minify the script files. If not, only copy them.
for SCRIPT in $SCRIPTS
do
    MINIFIEDNAME=`echo $SCRIPT | sed 's/.js/.min.js/'`
    if [ "$RELEASE" == "true" ]
    then
        curl -X POST -s --data-urlencode "input@${SCRIPT}" https://javascript-minifier.com/raw > $MINIFIEDNAME
    else
        cp $SCRIPT $MINIFIEDNAME
    fi
done

# Find all css files
for FOLDER in $CSSFOLDERS
do
    CSSFILES=`find $FOLDER -name "*.css" -not -name *.min.css -type f -printf '%p '`
done


# If this is a release, minify the css files. If not, only copy them.
for CSSFILE in $CSSFILES
do
    MINIFIEDNAME=`echo $CSSFILE | sed 's/.css/.min.css/'`
    if [ "$RELEASE" == "true" ]
    then
        curl -X POST -s --data-urlencode "input@${CSSFILE}" http://cssminifier.com/raw > $MINIFIEDNAME
    else
        cp $CSSFILE $MINIFIEDNAME
    fi
done

# Get current version
VERSION=`grep "Version:" $INFOFILE | sed 's/Version: //' | sed 's/^[ \t]*//;s/[ \t]*$//'`

# Create archives
tar -c -z -f ../${PKGNAME}-${VERSION}.tar.gz --exclude-vcs --exclude=*.kdev4 --exclude=.kdev4 --exclude=package.sh *
zip -q -r ../${PKGNAME}-${VERSION}.zip * -x \*.sh -x \*.kdev4