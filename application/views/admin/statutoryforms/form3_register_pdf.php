<style>
	body{ font-family: sans-serif; font-size: 10px; }
	table{ width:100%; border-collapse: collapse; }
	th,td{ border:1px solid #444; padding:3px 4px; vertical-align:top; }
	th{ background:#e6e6e6; }
	.c{ text-align:center; }
	h3,p{ margin:2px 0; }
</style>
<div class="c"><h3>REGISTER MAINTAINED IN THE OFFICE OF THE STATE RECORD KEEPING AGENCY (FORM-3)</h3></div>
<table>
	<thead>
		<tr>
			<th>Sr.</th><th>PRAN</th><th>Name of Employee</th><th>DOB</th><th>Date of Joining</th>
			<th>Designation</th><th>Pay Center</th><th>Nominee(s) [Name / Relationship / Share %]</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!empty($apps)): $i=1; foreach($apps as $a):
			$full = trim($a['first_name'].' '.$a['middle_name'].' '.$a['last_name']); ?>
		<tr>
			<td class="c"><?php echo $i++; ?></td>
			<td><?php echo html_escape($a['pran_no']); ?></td>
			<td><?php echo html_escape($full); ?></td>
			<td><?php echo html_escape($a['dob']); ?></td>
			<td><?php echo html_escape($a['date_of_joining']); ?></td>
			<td><?php echo html_escape($a['designation_name']); ?></td>
			<td><?php echo html_escape($a['pay_center']); ?></td>
			<td>
				<?php if(!empty($a['nominees'])): foreach($a['nominees'] as $n): ?>
					<?php echo html_escape($n['nominee_name'].' / '.$n['relationship'].' / '.$n['share_percentage'].'%'); ?><br>
				<?php endforeach; else: echo '&ndash;'; endif; ?>
			</td>
		</tr>
		<?php endforeach; else: ?>
		<tr><td colspan="8" class="c">No records.</td></tr>
		<?php endif; ?>
	</tbody>
</table>
<p style="margin-top:40px; text-align:right;"><strong>Signature</strong><br>Authorised Officer, S.R.K.A.</p>
