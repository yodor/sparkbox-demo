sparkbox-demo
=============

The core components of [SparkBox](https://github.com/yodor/sparkbox), each on a page - a core site (no store layer)
on the module engine. Live at https://sparkbox.saturnosoft.org

| Page | Path | Shows |
|---|---|---|
| Home | `/` | the demo pages |
| Input Controls | `/controls` | `InputForm`, the input types of `DataInputFactory`, validation, the VBox / HBox layout |
| Array Controls | `/controls/arrays` | `ArrayDataInput` + `ArrayField`: values the visitor adds and removes |
| Uploads | `/controls/uploads` | session image / file uploads, the chunked upload |
| Text Editor | `/controls/editor` | `MCETextArea` with its image browser, the sanitized HTML |
| Dialogs | `/dialogs` | `MessageDialog`, `ConfirmMessageDialog`, `InputMessageDialog`, `JSONFormDialog` + `JSONFormResponder` |
| Image Gallery | `/gallery` | `GalleryTape`, `ImagePopup`, the storage (photos uploaded in the admin: Demo > Gallery) |
| Tree View | `/tree` | `NestedSetTreeView` of a `NestedSetBean` |
| Menus | `/menus` | `MenuBar` of a menu built in code and of a bean (`BeanMenuFactory`) |
| Fragments | `/fragments` | `ContentFragment`: the content of another path loaded into the page |
| News, FAQ, Admin | `/news/`, `/faq/`, `/admin/` | the core modules in the demo frame |

Setting up
----------

1. A database and its account - no schema to import: the beans create their tables on first use (the tree view
   adds its sample nodes on its first visit).
2. `config/dbconfig.php` from `config/dbconfig.php.dist` (not in git).
3. `.htaccess` from `.htaccess.dist` (replace the `_PLACEHOLDERS_`) - or `.user.ini` for PHP-FPM.
4. Link the core folders into the document root (relative to where sparkbox is checked out):

       ln -s ../sparkbox/sparkfront sparkfront
       ln -s ../sparkbox/modules/admin admin
       ln -s ../sparkbox/modules/pages pages
       ln -s ../sparkbox/modules/news news
       ln -s ../sparkbox/modules/faq faq

5. An administrator: the first one is added to `admin_users` (the password with `PasswordHash`), or copied from
   another site.

What is where
-------------

| | |
|---|---|
| `class/pages/DemoPage.php` | the frame: the core site frame (`SparkSitePage`) with the menu of the demo pages |
| `class/templates/modules/main` | the demo pages - a path file and a content (`content/*Content.php`) each; the old scripts → 301 |
| `class/templates/modules/admin` | Demo > Gallery (the photos of the gallery page) |
| `class/templates/modules/{pages,news,faq}` | the core modules in the demo frame |
| `class/beans` | `GalleryPhotosBean`, `DemoTreeBean` |
| `css/demo.css` | the look of the demo on the core theme |
| `tests/` | the site tests (sparkbox `tests/run.php --dir=<site>/tests`) |
