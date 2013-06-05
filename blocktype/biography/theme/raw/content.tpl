{foreach $entries name=entries key=type item=table}
    <h2>{str tag='$type' section='artefact.epos'}</h2>
    {$table|safe}
{/foreach}
