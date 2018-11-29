# Setup cronjob at Mittwald shared host

## Add Bash Script Wrapper

1. Create executable shell script `touch ~/html/TYPO3Scheduler.sh`
2. Insert content and adopt TYPO3_CONTEXT and Username and correct path to TYPO3 CLI entryscript:
  ```
  #!/bin/bash
  TYPO3_CONTEXT=Production/Dev /usr/local/bin/php_cli ~/html/typo3/web/typo3/sysext/core/bin/typo3 scheduler:run
  ```
3. Make script executable `chmod +x ~/html/TYPO3Scheduler.sh`
4. Test script `~/TYPO3Scheduler.sh`

### One Liner Command Examples

- Production/Dev `touch ~/html/TYPO3Scheduler.sh && chmod +x ~/html/TYPO3Scheduler.sh && echo -e '#!/bin/bash\nTYPO3_CONTEXT=Production/Dev /usr/local/bin/php_cli ~/html/app/web/typo3/sysext/core/bin/typo3 scheduler:run' >> ~/html/TYPO3Scheduler.sh`
- Production/Staging `touch ~/html/TYPO3Scheduler.sh && chmod +x ~/html/TYPO3Scheduler.sh && echo -e '#!/bin/bash\nTYPO3_CONTEXT=Production/Staging /usr/local/bin/php_cli ~/html/app/web/typo3/sysext/core/bin/typo3 scheduler:run' >> ~/html/TYPO3Scheduler.sh`
- Production/Live `touch ~/html/TYPO3Scheduler.sh && chmod +x ~/html/TYPO3Scheduler.sh && echo -e '#!/bin/bash\nTYPO3_CONTEXT=Production/Live /usr/local/bin/php_cli ~/html/app/web/typo3/sysext/core/bin/typo3 scheduler:run' >> ~/html/TYPO3Scheduler.sh`

## Add cronjob via Mittwald Customer Panel

* Call: serverside
* Title: TYPO3 Scheduler
* Path to Script: `/html/TYPO3Scheduler.sh`
* Parameter: no parameter needed
* Inform via E-Mail on errors: if you want/need
* select execution plan for the cronjob (select the timeframe as small as possible, depends on your plan)
