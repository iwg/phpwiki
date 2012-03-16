An Enterprise Wiki in PHP
==========================

Markup Language
----------------
- Provide a subset of MediaWiki syntax (considering to use [Mediawiki2HTML machine](http://johbuc6.coconia.net/doku.php/mediawiki2html_machine/code))
- `<math>...</math>` tag for MathJax (rendering LaTeX formulas in browsers)
- `<markdown>...</markdown>` tag for embedding Markdown markups
- Utilize [Pandoc](http://johnmacfarlane.net/pandoc/) for migrating markups

About Permissions
------------------
- Distinguish group users and other users
- `rwx`-bits:
  - `r` for reading the page
  - `w` for editing the page
  - `x` for creating subpage, e.g. `/a/b` is a subpage of `/a`

Page Locking
-------------
[how DokuWiki do it](http://www.dokuwiki.org/locking).

You can't edit the page while another's editing the same page

Set a lock:
  - When user gets into edit-page.php
Refresh a lock:
  - When user hits the preview button
Lock is expired:
  - It is more then xxx seconds old (xxx: 'LOCK_TIME' in /inc/config.php)
Lock is deleted:
  - When user hots the save button
ToDo:
  - Refresh the lock in the background while user is editing page
  - Section level locking
  - Delete the lock when user hits the cancel button
