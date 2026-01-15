// JavaScript Document

function add()
{
	window.location.href = 'index.php?view=add';
}

function mod(id)
{
	window.location.href = 'index.php?view=modify&id=' + id;
}

function view(id)
{
	window.location.href = 'index.php?view=detail&id=' + id;
}

function due(id)
{
	window.location.href = 'index.php?view=due&id=' + id;
}

function del(id)
{
	if (confirm('Delete this supplier?')) {
		window.location.href = 'processDelete.php?id=' + id;
	}
}

function delimg(id)
{
	if (confirm('Delete this image?')) {
		window.location.href = 'processDeleteImage.php?id=' + id;
	}
}
