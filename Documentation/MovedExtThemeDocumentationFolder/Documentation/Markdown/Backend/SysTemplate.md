Back to [Index](../Index.md) / Back to [Backend Index](Index.md)

# `sys_template` enhancements

## No `sys_template` records in the database

> Every sys_template record must be added through a hook
> ([TypoScriptHook.php](../../../Classes/Hooks/Frontend/TypoScriptHook.php)).
> This prevents technical debts and makes reckless creation of
> `sys_template` records on subpages impossible

### Hook to load `sys_template`

Please see
[TypoScriptHook.php](../../../Classes/Hooks/Frontend/TypoScriptHook.php)

### How is the restriction enforced?

* Page TS Config restriction `Tceform.pages.TSConfig.disabled = 1`
* EditDocumentController Signal Slot
  [EditDocumentControllerInitSlot.php](../../../Classes/Signals/Backend/EditDocumentControllerInitSlot.php)
* TypoScriptTemplateModuleController Hook
  [NewStandardTemplateHandler.php](../../../Classes/Hooks/Backend/NewStandardTemplateHandler.php)
* DataHandler Hook
  [ProcessDatamapDataHandler.php](../../../Classes/Hooks/Backend/ProcessDatamapDataHandler.php)
