#!/bin/bash

# This ideally wouldn't be required, but we need some Git checkouts, and submodules are not quite what we need.

# We need a checkout of meta
[[ -d glotpress.git ]] || git clone https://github.com/GlotPress/GlotPress-WP.git glotpress.git
[[ -d meta.git ]] || git clone https://github.com/wordpress/wordpress.org meta.git

# We need a checkout of theme-check
[[ -d wp-content/plugins/theme-check ]] || git clone https://github.com/wordpress/theme-check wp-content/plugins/theme-check
