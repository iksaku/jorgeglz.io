<?php

namespace Deployer;

desc('Builds custom nova components');
task('nova:build', '{{bin/yarn}} build-nova-extended-markdown-prod');
