An Enterprise Wiki in PHP
==========================

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
