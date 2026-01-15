// JavaScript Document

function detail(id)
{
	window.location.href = 'index.php?view=detail&id=' + id;
}

function del(oId)
{
	if (confirm('Delete this order?')) {
		window.location.href = 'processDelete.php?oid=' + oId;
	}
}