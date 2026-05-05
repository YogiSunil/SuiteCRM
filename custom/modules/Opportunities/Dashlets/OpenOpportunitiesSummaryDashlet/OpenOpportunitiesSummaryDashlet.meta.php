<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $app_strings;

$dashletMeta['OpenOpportunitiesSummaryDashlet'] = array(
    'module' => 'Opportunities',
    'title' => translate('LBL_OPEN_OPPORTUNITIES_SUMMARY_TITLE', 'Opportunities'),
    'description' => 'Shows open opportunities summary stats for the current user',
    'category' => 'Module Views',
);
