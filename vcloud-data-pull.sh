#!/bin/bash 
#
# Use this script to easily extract vCloud info
#

if [ "$1" == "" ] || [ "$2" == "" ]; then 
  
  echo -e "Please choose the vDC you wish to audit as set up in your .fog file:"
  read ENV

  echo -e "Please enter what you wish to audit: (vms, vedge)"
  read TYPE

else 

  ENV=$1
  TYPE=$2

fi

OUTPUT="output.$TYPE.$ENV.$RANDOM"
  
echo "Thank you. Your Skyscape login is required."
eval $(FOG_CREDENTIAL=$ENV vcloud-login)

case $TYPE in 
  vms)
    FOG_CREDENTIAL=$ENV vcloud-walk vdcs > $OUTPUT;;
    
  vedge) 
    FOG_CREDENTIAL=$ENV vcloud-walk edgegateways > $OUTPUT;;
esac

echo "Now run the PHP scripts, using $OUTPUT as your argument:"

if [[ $TYPE == "vms" ]]; then
  echo -e "php bin/vms-audit.php $OUTPUT\n"
elif [[ $TYPE == "vedge" ]]; then 
  echo -e "php bin/vedge.php $OUTPUT <acl or nat>\n"
fi

echo "Remember, you need the right data file for the output to make any sense"
