# phpscript_compatibility
Backwards compatibility of PHP_SCRIPT (TYPO3 Extension)

This extension makes the following TypoScript Snippet work with TYPO3 6.2 and up:

```
my_php_script = PHP_SCRIPT
my_php_script {
    file = fileadmin/my_php_script.php
}
```

**This extension should only be used for compatibility reasons! Please use [Userfunctions](https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/UserAndUserInt/Index.html) instead!**


See https://www.youtube.com/watch?v=15_HsnC_60Q
