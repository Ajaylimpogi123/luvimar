// JavaScript Document

function detail(oId)
{
	window.location.href = 'index.php?view=detail&oid=' + oId;
}

function del(oId)
{
	if (confirm('Change status to delivered?')) {
		window.location.href = 'processDelete.php?oid=' + oId;
	}
}