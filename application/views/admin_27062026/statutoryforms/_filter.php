<?php
/**
 * Shared filter bar for the statutory-form screens.
 * Expects: $action (GET url), $show (subset of month/year/pay_center),
 *          $months, $years, $pay_centers, and current $month/$year/$pay_center.
 */
$show       = isset($show) ? $show : array('month','year','pay_center');
$month      = isset($month) ? $month : '';
$year       = isset($year) ? $year : '';
$pay_center = isset($pay_center) ? $pay_center : '';
?>
<form method="get" action="<?php echo $action; ?>" class="form-inline" style="margin-bottom:15px;">
	<?php if(in_array('month', $show)): ?>
	<div class="form-group">
		<label>Month&nbsp;</label>
		<select name="month" class="form-control">
			<option value="">-- Month --</option>
			<?php foreach($months as $m): ?>
			<option value="<?php echo $m['id']; ?>" <?php echo ((string)$month === (string)$m['id'])?'selected':''; ?>><?php echo html_escape($m['month']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>&nbsp;
	<?php endif; ?>

	<?php if(in_array('year', $show)): ?>
	<div class="form-group">
		<label>Year&nbsp;</label>
		<select name="year" class="form-control">
			<option value="">-- Year --</option>
			<?php foreach($years as $y): ?>
			<option value="<?php echo $y['year']; ?>" <?php echo ((string)$year === (string)$y['year'])?'selected':''; ?>><?php echo html_escape($y['year']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>&nbsp;
	<?php endif; ?>

	<?php if(in_array('pay_center', $show)): ?>
	<div class="form-group">
		<label>Pay Center / DDO&nbsp;</label>
		<select name="pay_center" class="form-control">
			<option value="">-- All --</option>
			<?php foreach($pay_centers as $p): ?>
			<option value="<?php echo html_escape($p['pay_center']); ?>" <?php echo ((string)$pay_center === (string)$p['pay_center'])?'selected':''; ?>><?php echo html_escape($p['pay_center']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>&nbsp;
	<?php endif; ?>

	<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Show</button>
	<?php
	// "Download PDF" repeats the current query string with pdf=1
	$qs = $_GET; $qs['pdf'] = 1;
	$pdfUrl = $action.'?'.http_build_query($qs);
	?>
	<a href="<?php echo $pdfUrl; ?>" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
	<button type="button" class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
</form>
