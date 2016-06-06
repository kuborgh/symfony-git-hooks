# symfony-git-hooks
Collection of git hooks, used in symfony projects

Motivation
----------
This project was inspired by a copy&paste solution of different internal projects and by other existing projects which were 
* some kind of overkill (https://github.com/bruli/php-git-hooks)
* very specialized (https://github.com/partnermarketing/pm-git-hooks-php)
* too configurable (https://github.com/aequasi/git-hook-handler).

The goal is to build a package, than can be installed automatically in no time and will do just 2-3 simple checks.
Also it should only consider Symfony2 coding standards and nothing else. 

Installation
------------
1. Add package to composer
```bash
composer require kuborgh/symfony-git-hooks @dev-master
```

2. Add scripts to composer (as it can not be done automatically https://github.com/composer/composer/issues/1193)
```json
    "scripts": {
        "post-package-install": [
            "Kuborgh\\GitHook\\ComposerInstaller::installHooks"
        ],
        "post-package-update": [
            "Kuborgh\\GitHook\\ComposerInstaller::installHooks"
        ]
    }
```
