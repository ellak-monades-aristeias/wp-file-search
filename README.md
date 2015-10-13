## wp-file-search
**WP File Search** is a Wordpress plugin that parses and stores the content of attachment files (pdf, docx and odt) so that they can be later searched from WP's default search.

### Requirements
WP File Search has been successfully tested on Wordpress (4.2.5), using Apache (2.2), PHP (>= 5.3) and MySQL (>= 5.5). It will, most probably, work on earlier versions of the software stack mentioned, however it has never been tested these versions. For any compatibility issue contact the authors, or even better, open an [issue](https://github.com/ellak-monades-aristeias/wp-file-search/issues) on github.

### Installation
You can either install the plugin from [Wordpress plugin directory](https://wordpress.org/plugins/) or `git clone`/download the zip file directly from github. For the latter case you should have [composer](http://getcomposer.org/) installed on your system and run `composer install` inside the plugin directory.

### Branches
The plugin uses two active branches:
 - A `master` branch, which contains the stable, tested code of the app. This branch reflects the latest official plugin version and is also accessible though [Wordpress plugin directory](https://wordpress.org/plugins/).
 - A `development` branch, reflecting the current state of the our codebase and the bugfixes/features to be included in the next release. Whenever a new version releases, `development` branch is merged with `master` branch.

Any other branch is considered *experimental* or under development, so please avoid working or cloning them.

### Wiki
A [plugin wiki](https://github.com/ellak-monades-aristeias/wp-file-search/wiki/%CE%94%CE%B9%CE%B1%CF%87%CE%B5%CE%AF%CF%81%CE%B9%CF%83%CE%B7-%CE%88%CF%81%CE%B3%CE%BF%CF%85) is currently available only in Greek, but there are plans to translate its content in English. The wiki contains installation instructions, a user guide and extension guidelines for developers.

### Issues
You can add new issues on out github repository, but please use the correct labeling.
 - Use `enhancement` label to describe a new issue that you want to be implemented.
 - Use `bug` label to report any bugs that affects the plugin functionality.

`user stories` label is used internally to indicate initial requirements or to breakdown the enhancement label.
