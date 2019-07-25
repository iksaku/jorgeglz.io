<?php

namespace Deployer;

desc('Installs yarn dependencies on custom nova components');
task('nova:install', 'cd nova-components/NovaExtendedMarkdown && {{bin/yarn}} install');

desc('Builds custom nova components');
task('nova:build', '{{bin/yarn}} build-nova-extended-markdown-prod');
