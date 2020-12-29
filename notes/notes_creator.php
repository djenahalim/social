
<?php
session_start();
//include "header.php"; ?>

<form action="/www/notes/notes_creation.php" method="post">
<table style="border: 1px;">

<td><textarea class="form-control" type="text" placeholder="write a note " name="note" size="255"
maxlength="255" rows="4" cols="50"></textarea>
</tr>
<tr>
<td colspan="2" style="text-align: center;"><input type="submit" class="btn btn-secondary" id="add_note_btn" value="Add Note" /></td>
</tr>
</table>
</form>
