# GlotPress - Local development environment

## Prerequisites
- Git
- Docker
- Node/NPM

## Setup
1. `git clone https://github.com/amieiro/glotpress-env`
2. `cd glotpress-env`
3. `npm install`
4. `npm run start` (This will provision some git checkouts as needed).
5. Visit site at <a href="http://localhost:8888" target="_blank"> http://localhost:8888 </a>.
6. To access to GlotPress, please, click <a href="http://localhost:8888/glotpress/projects/" target="_blank">here</a>.

## Import data

Execute:

`npm run wp-env run cli wp glotpress import-originals core wp-content/uploads/wordpress.po &&`

`npm run wp-env run cli wp glotpress import-originals themes/twenty-twenty wp-content/uploads/twenty-twenty.po &&`

`npm run wp-env run cli wp glotpress import-originals themes/twenty-twenty-one wp-content/uploads/twenty-twenty-one.po &&`

`npm run wp-env run cli wp glotpress import-originals plugins/akismet wp-content/uploads/akismet.po &&`

`npm run wp-env run cli wp glotpress import-originals plugins/woocommerce wp-content/uploads/woocommerce.po &&`

`npm run wp-env run cli wp glotpress import-originals plugins/jetpack wp-content/uploads/jetpack.po`

## Stopping Environment
`npm run wp-env stop`

## Removing Environment
`npm run wp-env destroy`

## More info

This tool is based on [WordPress Theme Directory - Local development environment](https://github.com/WordPress/theme-directory-env).

This tool uses the [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)
Docker environment.