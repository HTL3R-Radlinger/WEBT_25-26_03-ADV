# WEBT_25-26_03-ADV

WEBT-VT | ADV | 03 - Coding Standards

### PHP Interpreter aus Docker in PhpStorm einrichten

* File -> Settings -> PHP
* Auf `...` neben **CLI Interpreter** klicken
* `+` -> **From Docker** -> **Docker Composer**
- **Server:** Docker
- **Configuration file:** `./WEBT_25-26_03-ADV/docker-compose.yaml`
- **Service:** `web`
- **PHP executable:** `/usr/local/bin/php`

**Lifecycle:** Connect to existing container ('docker-compose exec')
**CLI Interpreter:** `web`

### PHP CS Fixer in PhpStorm konfigurieren

* File -> Settings -> PHP -> Quality Tools -> PHP CS Fixer
* Auf `...` neben **Configuration** klicken
* `+` -> **Interpreter:** `web`
* **PHP CS Fixer path:** `./vendor/bin/php-cs-fixer`
* **Path mappings:** Map ADV3 Folder to `/var/www/html`

### Reformat specific File with PhpStorm
`Ctrl + Shift + A -> "Fix CS"`

### Reformat at File save
* File -> Settings -> PHP -> Quality Tools -> **External Formatters:** `PHP CS Fixer`
* `Settings -> Tools -> Action on Save`
- Select `Reformat code` & `Rearrange code`

















## Composer Infos

* `composer require --dev friendsofphp/php-cs-fixer`
* `vendor/bin/php-cs-fixer fix` for cmd refactoring
