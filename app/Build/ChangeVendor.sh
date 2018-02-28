#! /bin/bash

# Run this script with your desired vendor name in UpperCaseCamelCase:
# ./ChangeVendor.sh YourNewUpperCamelCaseVendorName

# define existing/new vendor name
Vendor="JosefGlatz"
VendorLowercase="$(echo ${Vendor} | tr '[A-Z]' '[a-z]')"
VendorNew="$1"
VendorNewLowercase="$(echo ${VendorNew} | tr '[A-Z]' '[a-z]')"

# if script is called without argument, add info about missing argument
if [ $# -ne 1 ]
then
	echo "Usage: $0 MyNewUpperCamelCaseVendorName"
	exit 1
fi

# make vendor name changes
echo "Changing vendor names to"
echo "- ${VendorNew} (original)"
echo "- ${VendorNewLowercase} (lowercase incidents)"
echo " "

grep -rl $Vendor ../ --include composer.json |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $Vendor ../web/typo3conf/ext/theme |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $Vendor ../web/typo3conf/AdditionalConfiguration.php |xargs sed -i -e "s/$Vendor/$VendorNew/"
echo "> Changed all known occurrences from $Vendor to $VendorNew."
echo " "
grep -rl $Vendor ../ --include composer.json |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $VendorLowercase ../web/typo3conf/ext/theme |xargs sed -i -e "s/$VendorLowercase/$VendorNewLowercase/"
echo "> Changed all known occurrences from $VendorLowercase to $VendorNewLowercase."

echo " "
echo "Have fun with this TYPO3 distribution (and of course, your new vendor name)!"
echo " "
echo "Please check in your git working copy, if the script did only what you want ;-)"
