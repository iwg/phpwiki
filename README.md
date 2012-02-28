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
See [how DokuWiki do it](http://www.dokuwiki.org/locking). We will do it similarly. 
Key points: 

- Locked are refreshed:
  - When the preview button is pressed
  - When JavaScript is available the wiki will refresh the lock in the background while editing the document
- Locks do expire when:
  - they are older than the defined age (10 minutes?)
  - the editing user saves the page
  - the editing user cancels the editing by hitting the cancel button

DokuWiki only enables page-level locking. We will consider section-level locking for better usability. 
