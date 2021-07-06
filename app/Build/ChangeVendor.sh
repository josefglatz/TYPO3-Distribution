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

bold=$(tput bold)
normal=$(tput sgr0)
red=`tput setaf 1`
green=`tput setaf 2`

# make vendor name changes
echo "Changing vendor names to"
echo "- ${VendorNew} (original)"
echo "- ${VendorNewLowercase} (lowercase incidents)"
echo " "

grep -rl $Vendor ../ --include composer.json |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $Vendor ../packages/theme |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $Vendor ../config/AdditionalConfiguration.php |xargs sed -i -e "s/$Vendor/$VendorNew/"
echo "> ${green}Changed all known occurrences${normal} from $Vendor to $VendorNew."
echo " "
grep -rl $Vendor ../ --include composer.json |xargs sed -i -e "s/$Vendor/$VendorNew/"
grep -rl $VendorLowercase ../packages/theme |xargs sed -i -e "s/$VendorLowercase/$VendorNewLowercase/"
echo "> ${green}Changed all known occurrences${normal} from $VendorLowercase to $VendorNewLowercase."

echo " "
echo "Have fun with this TYPO3 distribution"
echo "(and of course, your new vendor name)!"
echo " "
echo "Please check in your git working copy, if the script did only what you want ;-)"
echo " "
echo " "
echo " "
echo "${green}${bold}Please consider adding yourself as a stargazer if you benefit from my TYPO3-Distribution!${normal}"
echo "Visit https://github.com/josefglatz/TYPO3-Distribution/stargazers and give a star!"
