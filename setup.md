<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="wp-admin/css/install.css?ver=20100228" type="text/css" />
</head>
<body>

# otestsite
For testing out WP workflow tools for private.
[![Build Status](https://travis-ci.org/OWL-Labs/WordPress-Pantheon.svg?branch=master)](https://travis-ci.org/OWL-Labs/WordPress-Pantheon)

<p style="text-align: center">
[[For more]](https://github.com/OWL-Labs/Notepad/blob/master/working_with_pantheon.md)</p>

## Upgrading

Pantheon will prompt you when there are upstream updates for WordPress Core to install. If there is a conflict (e.g. in `README.md`) then you can manually merge from the upstream via:

```bash
git remote add upstream https://github.com/pantheon-systems/WordPress.git
git checkout master
git pull -X mine upstream master
git checkout origin/master -- readme.html # any files that you modified
git diff --staged # sanity check
git commit
git push origin master
```
## Public Environments and Deployments

The site is hosted with Pantheon.

Add the Pantheon repo as a remote on you existing GitHub clone:

```bash
git remote add pantheon ssh://codeserver.dev.[]@codeserver.dev.[].drush.in:2222/~/repository.git
```

Then you can deploy simply by merging any feature branches into the `master` branch on GitHub (via pull request), and then just do:

```bash
git checkout master && git pull origin && git push pantheon
```


<h2>otestsite</h2>

1. Get otestsite git repo.

```
cd ../www/otestsite
then
git clone --recursive git@github.com:OWL-Labs/WordPress-Pantheon.git htdocs
cd htdocs
```

2. Config values.

These are found in the `Dev Scripts` folder.
  
</body>
</html>
