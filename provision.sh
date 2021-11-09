#!/bin/bash

# This ideally wouldn't be required, but we need some Git checkouts, and submodules are not quite what we need.

# We need a checkout of meta
[[ -d glotpress.git ]] || git clone https://github.com/GlotPress/GlotPress-WP.git glotpress.git