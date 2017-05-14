#! /bin/bash

# This script is indented to run within the docker container "app" (because it need database access)
#
# Execution from within the shell in the app container: `/app/Build/InstallDefaultDatabaseRecords.sh`
# Execution from outside with clitools docker:exec command: `ct docker:exec /app/Build/InstallDefaultDatabaseRecords.sh`

echo "Begin importing default database records"
echo " "
echo " "
/app/typo3cms import:table "tx_scheduler_task_group" "uid" "/app/Build/DefaultDatabaseRecords/tx_scheduler_task_group.yml"
/app/typo3cms import:table "tx_scheduler_task" "uid" "/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml"
/app/typo3cms import:backendgroups "uid" "/app/Build/DefaultDatabaseRecords/be_groups.yml"
/app/typo3cms import:backendusers "username" "/app/Build/DefaultDatabaseRecords/be_users.yml"
/app/typo3cms import:table "pages" "uid" "/app/Build/DefaultDatabaseRecords/pages.yml"
/app/typo3cms import:table "sys_domain" "uid" "/app/Build/DefaultDatabaseRecords/sys_domain.yml"
/app/typo3cms import:table "sys_template" "uid" "/app/Build/DefaultDatabaseRecords/sys_template.yml"
/app/typo3cms import:frontendgroups "uid" "/app/Build/DefaultDatabaseRecords/fe_groups.yml"
/app/typo3cms import:frontendusers "username" "/app/Build/DefaultDatabaseRecords/fe_users.yml"
/app/typo3cms import:table "sys_be_shortcuts" "uid" "/app/Build/DefaultDatabaseRecords/sys_be_shortcuts.yml"
echo " "
echo " "
echo "Finalized the import of default database records"
