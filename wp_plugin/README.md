# WIDEN COLLECTIVE WORDPRESS PLUGIN

INTRODUCTION
------------

Widen develop software solutions for marketers who need to connect their visual
content – like graphics, logos, photos, videos, presentations and more –
for greater visibility and brand consistency.

This plugin allows your Wordpress projects to connect to the API of the Digital
Asset Management system Widen Collective with the WYSIWYG TinyMCE Editor.


INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. See:
   https://codex.wordpress.org/Managing_Plugins
   for further information.
 * Alternatively, you can place the content of this plugin in wp-content/plugins/ and enable from the plugins manager.


CONFIGURATION
-------------

 * Configure your access details to Widen Collective in Admin / Settings / Widen Collective Settings:

   - Widen Collective Authorization

     Enter the address of your Widen Collective domain and click the Authorize button.
     It is recommended that each Wordpress user connects to his or her own Widen
     account, and therefore see just the assets they have access to. Any
     content editor that wants to use Widen assets needs to have an account.


FAQ
---

Q: Are the authorization tokens being stored in the database?

A: This Wordpress plugin stores the authentication token that was generated
  from the domain set in the config above. The authentication is done on the Widen website,
  and the module  only uses a connection token.

Q: Can a content editor not using the WYSIWYG use Widen Collective assets?

A: The module Widen Community integrates with TinyMCE WYSIWYG editor that comes with
  Default WP install. If the editor does not use a WYSIWYG, you can
  alternatively obtain a specific URL for each of your assets directly from the
  Widen Collective website's interface.


MAINTAINERS
-----------

Current maintainers:
* Prometsource - https://www.prometsource.com/

This project has been sponsored by:
* WIDEN
  Widen is a content technology company that powers the content that builds
  your brand with our global cloud-based digital asset management solutions.
  Built on more than 65 years of creative workflow experience and 20 years of
  Software as a Service (SaaS), Widen is the trusted leader in Digital Asset
  Management. More information on https://www.widen.com
