<table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td width="20%">{$titleLBL}</td>
        <td width="80%">
            <input type="text" name="title" size="40" value="{$title}">
        </td>
    </tr>
    {if $isRefreshable}
    <tr>
        <td>{$autoRefresh}</td>
        <td>
            <select name='autoRefresh'>
                {html_options options=$autoRefreshOptions selected=$autoRefreshSelect}
            </select>
        </td>
    </tr>
    {/if}
    <tr>
        <td colspan="2" align="right">
            <input type="submit" class="button" value="{$saveLBL}">
        </td>
    </tr>
</table>
<input type='hidden' name='id' value='{$id}'>
