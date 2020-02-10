#! /bin/bash

# This script is indented to run within the docker container "app" (because it need database access)
#
# Execution from within the shell in the app container: `/app/Build/InstallDefaultDatabaseRecords.sh`
# Execution from outside with clitools docker:exec command: `ct docker:exec /app/Build/InstallDefaultDatabaseRecords.sh`

echo "Begin importing default database records"
echo " "
echo " "
/app/typo3cms yaml:import 'sys_be_shortcuts' --matchFields='uid'
/app/typo3cms yaml:import 'tx_scheduler_task_group' --matchFields='uid'
/app/typo3cms yaml:import 'tx_scheduler_task' --matchFields='uid'
/app/typo3cms yaml:import 'sys_filemounts' --matchFields='uid'
/app/typo3cms yaml:import 'be_groups' --matchFields='uid'
/app/typo3cms yaml:import 'be_users' --matchFields='uid'
/app/typo3cms yaml:import 'pages' --matchFields='uid'
/app/typo3cms yaml:import 'tt_content' --matchFields='uid'
/app/typo3cms yaml:import 'fe_groups' --matchFields='uid'
/app/typo3cms yaml:import 'fe_users' --matchFields='uid'
/app/typo3cms yaml:import 'tt_content' --matchFields='uid'
echo " "
echo " "
echo "Finalized the import of default database records"
