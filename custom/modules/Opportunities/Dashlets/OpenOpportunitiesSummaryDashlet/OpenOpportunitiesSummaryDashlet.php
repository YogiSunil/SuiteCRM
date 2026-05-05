<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/Dashlets/Dashlet.php');
require_once('custom/modules/Opportunities/Dashlets/OpenOpportunitiesSummaryDashlet/OpenOpportunitiesSummaryDashletUtils.php');

#[\AllowDynamicProperties]
class OpenOpportunitiesSummaryDashlet extends Dashlet
{
    protected $totalOpen = 0;
    protected $overdueOpen = 0;
    protected $totalAmountOpen = 0.0;

    public function __construct($id, $def = null)
    {
        global $current_user;

        parent::__construct($id);
        $this->isConfigurable = true;
        $this->isRefreshable = true;

        if (empty($def['title'])) {
            $this->title = translate('LBL_OPEN_OPPORTUNITIES_SUMMARY_TITLE', 'Opportunities');
        } else {
            $this->title = $def['title'];
        }

        if (isset($def['autoRefresh'])) {
            $this->autoRefresh = $def['autoRefresh'];
        }

        $this->seedBean = BeanFactory::newBean('Opportunities');

        $today = gmdate('Y-m-d');
        $this->totalOpen = (int) $this->fetchSingleValue(OpenOpportunitiesSummaryDashletUtils::totalOpenCountQuery($current_user->id), 'c');
        $this->overdueOpen = (int) $this->fetchSingleValue(OpenOpportunitiesSummaryDashletUtils::overdueOpenCountQuery($current_user->id, $today), 'c');
        $totalAmount = $this->fetchSingleValue(OpenOpportunitiesSummaryDashletUtils::totalOpenAmountQuery($current_user->id), 'total_amount');
        $this->totalAmountOpen = (float) ($totalAmount ?? 0);
    }

    protected function fetchSingleValue(string $query, string $column)
    {
        $result = $this->seedBean->db->query($query);
        $row = $this->seedBean->db->fetchByAssoc($result);

        if (!is_array($row) || !array_key_exists($column, $row)) {
            return 0;
        }

        return $row[$column];
    }

    public function display()
    {
        $smarty = new Sugar_Smarty();
        $smarty->assign('lblTotalOpen', translate('LBL_OPEN_OPPORTUNITIES_TOTAL', 'Opportunities'));
        $smarty->assign('lblOverdueOpen', translate('LBL_OPEN_OPPORTUNITIES_OVERDUE', 'Opportunities'));
        $smarty->assign('lblTotalAmount', translate('LBL_OPEN_OPPORTUNITIES_TOTAL_AMOUNT', 'Opportunities'));

        $smarty->assign('totalOpen', $this->totalOpen);
        $smarty->assign('overdueOpen', $this->overdueOpen);
        $smarty->assign('totalAmountOpen', number_format($this->totalAmountOpen, 2));

        return parent::display() . $smarty->fetch('custom/modules/Opportunities/Dashlets/OpenOpportunitiesSummaryDashlet/OpenOpportunitiesSummaryDashlet.tpl');
    }

    public function displayOptions()
    {
        $smarty = new Sugar_Smarty();
        $smarty->assign('titleLBL', translate('LBL_DASHLET_OPT_TITLE', 'Home'));
        $smarty->assign('title', $this->title);
        $smarty->assign('id', $this->id);
        $smarty->assign('saveLBL', $GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']);

        if ($this->isAutoRefreshable()) {
            $smarty->assign('isRefreshable', true);
            $smarty->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
            $smarty->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
            $smarty->assign('autoRefreshSelect', $this->autoRefresh);
        }

        return $smarty->fetch('custom/modules/Opportunities/Dashlets/OpenOpportunitiesSummaryDashlet/OpenOpportunitiesSummaryDashletConfigure.tpl');
    }

    public function saveOptions($req)
    {
        $options = array();

        if (isset($req['title'])) {
            $options['title'] = $req['title'];
        }

        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];

        return $options;
    }
}
