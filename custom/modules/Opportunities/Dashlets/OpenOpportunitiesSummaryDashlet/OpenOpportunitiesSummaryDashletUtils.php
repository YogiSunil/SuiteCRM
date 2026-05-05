<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class OpenOpportunitiesSummaryDashletUtils
{
    public static function escapedUserId(string $userId): string
    {
        return addslashes($userId);
    }

    public static function openOpportunitiesWhereClause(string $userId): string
    {
        $escapedUserId = self::escapedUserId($userId);

        return "assigned_user_id = '" . $escapedUserId . "'"
            . " AND deleted = 0"
            . " AND sales_stage NOT IN ('Closed Won', 'Closed Lost')";
    }

    public static function totalOpenCountQuery(string $userId): string
    {
        return "SELECT COUNT(*) AS c FROM opportunities WHERE " . self::openOpportunitiesWhereClause($userId);
    }

    public static function totalOpenAmountQuery(string $userId): string
    {
        return "SELECT SUM(amount_usdollar) AS total_amount FROM opportunities WHERE " . self::openOpportunitiesWhereClause($userId);
    }

    public static function overdueOpenCountQuery(string $userId, string $todayYmd): string
    {
        $escapedDate = addslashes($todayYmd);

        return "SELECT COUNT(*) AS c FROM opportunities WHERE " . self::openOpportunitiesWhereClause($userId)
            . " AND date_closed < '" . $escapedDate . "'";
    }
}
