#! /bin/bash

# This script is indented to run within the docker container "app" (because it need database access)
#
# Execution from within the shell in the app container: `/app/Build/InstallDefaultDatabaseRecords.sh`
# Execution from outside with clitools docker:exec command: `ct docker:exec /app/Build/InstallDefaultDatabaseRecords.sh`

echo "Begin importing default database records"
echo " "
echo " "
/app/typo3cms import:table 'tx_scheduler_task_group' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/tx_scheduler_task_group.yml'
/app/typo3cms import:table 'tx_scheduler_task' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml'
/app/typo3cms import:table 'sys_filemounts' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/sys_filemounts.yml'
/app/typo3cms import:backendgroups --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/be_groups.yml'
/app/typo3cms import:backendusers --match-fields='username' --file='/app/Build/DefaultDatabaseRecords/be_users.yml' --be-user-match-group-be-title='false'
/app/typo3cms import:table 'pages' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/pages.yml'
/app/typo3cms import:table 'sys_domain' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/sys_domain.yml'
/app/typo3cms import:frontendgroups --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/fe_groups.yml'
/app/typo3cms import:frontendusers --match-fields='username' --file='/app/Build/DefaultDatabaseRecords/fe_users.yml'
/app/typo3cms import:table 'sys_be_shortcuts' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/sys_be_shortcuts.yml'
/app/typo3cms import:table 'tt_content' --match-fields='uid' --file='/app/Build/DefaultDatabaseRecords/tt_content.yml'
echo " "
echo " "
echo "Finalized the import of default database records"
