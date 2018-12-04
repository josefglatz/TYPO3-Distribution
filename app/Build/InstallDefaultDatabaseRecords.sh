#! /bin/bash

# This script is indented to run within the docker container "app" (because it need database access)
#
# Execution from within the shell in the app container: `/app/Build/InstallDefaultDatabaseRecords.sh`
# Execution from outside with clitools docker:exec command: `ct docker:exec /app/Build/InstallDefaultDatabaseRecords.sh`

echo "Begin importing default database records"
echo " "
echo " "
/app/typo3cms import:table 'sys_be_shortcuts' --match-fields='uid'
/app/typo3cms import:table 'tx_scheduler_task_group' --match-fields='uid'
/app/typo3cms import:table 'tx_scheduler_task' --match-fields='uid'
/app/typo3cms import:table 'sys_filemounts' --match-fields='uid'
/app/typo3cms import:table 'be_groups' --match-fields='uid'
/app/typo3cms import:table 'be_users' --match-fields='uid'
/app/typo3cms import:table 'pages' --match-fields='uid'
/app/typo3cms import:table 'tt_content' --match-fields='uid'
/app/typo3cms import:table 'fe_groups' --match-fields='uid'
/app/typo3cms import:table 'fe_users' --match-fields='uid'
/app/typo3cms import:table 'tt_content' --match-fields='uid'
echo " "
echo " "
echo "Finalized the import of default database records"
