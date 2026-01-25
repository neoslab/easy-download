=== Easy Download ===
Contributors: NeosLab
Tags: download manager, document management, file manager, document management plugin, download monitor
Requires at least: 4.9
Tested up to: 6.8.3
Stable tag: 1.3.4
License URI: https://raw.githubusercontent.com/neoslab/easy-download/refs/heads/main/LICENSE

Easy Download help you to manage the files you offer to your users to download.

== Description ==

Easy Download help you to manage the files you offer to your users to download. The plugin allow you using a friendly interface to add or remove download links with a single click. Using Easy Download you can track the download activities of your website.

== Installation ==

1. Upload "easy-download" folder to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Navigate the "Easy Download" menu located in your dashboard sidebar to use or configure the plugin options.

== Screenshots ==

1. A general view of the plugin "options" page.
2. The form allowing you to add a new download link.
3. The table regrouping all the links that can be downloaded from your site.

== Changelog ==

= 1.3.4 (2026-01-25) =
* Corrected download redirection issue where binary files (like .deb packages) were opening in browser instead of downloading
* Proper MIME type detection system with `get_content_type()` helper function for 17+ file formats
* File serving mechanism now streams content directly through PHP for better download control
* Added Content-Disposition header with `attachment` flag to force file downloads
* Implemented binary content transfer encoding for proper handling of executable files
* Added chunked reading for large remote files (8KB chunks) to prevent memory issues
* Added `basename()` usage to prevent directory traversal attacks in filename headers
* SSL context configuration for secure remote file fetching from HTTPS sources
* Fallback mechanism to redirect if file streaming fails
* Cache control headers for better download performance and compatibility
* Content-Length header for local files to provide accurate download progress
* Error handling for both remote URLs and local file paths
* Changed from simple `header("Location:...")` to proper download headers
* Added support for streaming remote files with timeout and SSL options
* Implemented proper MIME types for common file formats (.deb, .exe, .zip, etc.)
* Maintained backward compatibility with existing statistics tracking system

* Code revision and optimization

= 1.3.3 (2025-12-29) =
* Code revision and optimization

= 1.3.2 (2025-11-19) =
* Fontawesome update
* Code revision and optimization

= 1.3.1 (2025-11-16) =
* Added WPML support for page content
* Code revision and optimization
* Security and performance audit

= 1.3.0 (2025-04-25) =
* Code revision and optimization

= 1.2.9 (2025-04-25) =
* Code revision and optimization

= 1.2.8 (2025-04-25) =
* Code revision and optimization

= 1.2.7 (2023-09-08) =
* Code revision and optimization

= 1.2.6 (2023-09-06) =
* Code revision and optimization

= 1.2.5 (2023-04-29) =
* Code revision and optimization

= 1.2.4 (2023-04-16) =
* Code revision and optimization

= 1.2.3 (2023-04-08) =
* Code revision and optimization

= 1.2.2 (2023-03-01) =
* Code revision and optimization

= 1.2.1 (2023-02-20) =
* Initial Public Release

== License ==

Good news, this plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial site.
