<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once 'custom/modules/Opportunities/Dashlets/OpenOpportunitiesSummaryDashlet/OpenOpportunitiesSummaryDashletUtils.php';

class OpenOpportunitiesSummaryDashletUtilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testOpenOpportunitiesWhereClauseContainsRequiredFilters(): void
    {
        $whereClause = OpenOpportunitiesSummaryDashletUtils::openOpportunitiesWhereClause('user-123');

        self::assertStringContainsString("assigned_user_id = 'user-123'", $whereClause);
        self::assertStringContainsString("deleted = 0", $whereClause);
        self::assertStringContainsString("sales_stage NOT IN ('Closed Won', 'Closed Lost')", $whereClause);
    }

    public function testTotalOpenCountQueryBuildsExpectedQuery(): void
    {
        $query = OpenOpportunitiesSummaryDashletUtils::totalOpenCountQuery('abc');

        self::assertStringStartsWith('SELECT COUNT(*) AS c FROM opportunities WHERE ', $query);
        self::assertStringContainsString("assigned_user_id = 'abc'", $query);
    }

    public function testTotalOpenAmountQueryBuildsExpectedQuery(): void
    {
        $query = OpenOpportunitiesSummaryDashletUtils::totalOpenAmountQuery('abc');

        self::assertStringStartsWith('SELECT SUM(amount_usdollar) AS total_amount FROM opportunities WHERE ', $query);
        self::assertStringContainsString("sales_stage NOT IN ('Closed Won', 'Closed Lost')", $query);
    }

    public function testOverdueOpenCountQueryIncludesDateFilter(): void
    {
        $query = OpenOpportunitiesSummaryDashletUtils::overdueOpenCountQuery('abc', '2026-05-05');

        self::assertStringContainsString("date_closed < '2026-05-05'", $query);
    }
}
