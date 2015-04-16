<div class="container" id="wrapper">
	<div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav in" id="side-menu">
				<li class="sidebar-search">
					<div class="input-group custom-search-form  hvr-bounce-in">
						<input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button> </span>
					</div>
					<!-- /input-group -->
				</li>
				<li>
					<a href="/index.php?control=Index&action=show" class=" hvr-bounce-in"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<li>
					<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in"> <i class="fa fa-cogs fa-fw"></i> Configure PTBuild<span class="fa arrow"></span> </a>
					<ul class="nav nav-second-level collapse">
						<li>
							<a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
						</li>
						<li>
							<a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">Users</a>
						</li>
						<li>
							<a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
						</li>
					</ul>
					<!-- /.nav-second-level -->
				</li>
				<li>
					<a href="/index.php?control=BuildConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Pipeline</a>
				</li>
				<li>
					<a href="/index.php?control=BuildList&action=show " class="active  hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines</a>
				</li>
				<!--<li>
					<a href="/index.php?control=Monitors&action=DefaultHistory" class=" hvr-bounce-in"><i class="fa fa-history fa-fw hvr-bounce-in"></i> History<span class="fa arrow"></span></a>
				</li> -->
			</ul>
		</div>
		<br />

		<div class="alert alert-info">
			<h4>Running Builds </h4>
			<div id="runningBuilds">
				<p>
					No builds currently being executed
				</p>
				
			</div>
		</div>

	</div>

	<div class="col-lg-9">
		<div class="well well-lg">
			<h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>

			<div class="row clearfix no-margin">
				<h4 class="text-uppercase text-light">A list of builds in a page</h4>
				<!--
				<h3>
				<a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">
				Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
				</h3>
				-->
				<div role="tabpanel">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a>
						</li>
						<li role="presentation">
							<a href="#success" aria-controls="success" role="tab" data-toggle="tab">All Success</a>
						</li>
						<li role="presentation">
							<a href="#failed" aria-controls="failed" role="tab" data-toggle="tab">All Failed</a>
						</li>
						<li role="presentation">
							<a href="#unstable" aria-controls="unstable" role="tab" data-toggle="tab">All Unstable</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="all">
							<div class="table-responsive" ">
							<table class="table table-striped table-bordered table-condensed">
							<thead>
							<tr style="background-color: fff">
							<th>#</th>
							<th>Pipeline</th>
							<th>Run Now</th>
							<th>Status</th>
							<th>Success</th>
							<th>Failure</th>
							<th>Duration</th>
							<!--
							<th>Parent</th>
							<th>Child</th>
							-->
							</tr>
							</thead>
							<tbody class="table-hover">

							<?php

							$i = 1;
							foreach ($pageVars["data"]["pipelines"] as $pipelineSlug => $pipelineDetails) { ?>
							<tr class="buildRow " id="blRow_<?php echo $pipelineSlug; ?>" >
							<th scope="row"><?php echo $i; ?> </th>
							<td><a style="font-weight: bold;font-size:16px;"; href="/index.php?control=BuildHome&action=show&item=<?php echo $pipelineSlug; ?>"><?php echo $pipelineDetails["project-name"]; ?>  </a> </td>
							
							<td>
							<?php
							echo '<a href="/index.php?control=PipeRunner&action=start&item=' . $pipelineDetails["project-slug"] . '">';
							echo '<i class="fa fa-play fa-2x hvr-grow-shadow" style="color:rgb(13, 193, 42);"></i></a>';
							?>
							</td>
							<td>
							<?php
							if ($pipelineDetails["last_status"] === true) {
								echo '<i class="fa fa-circle fa-2x " style="color:rgb(13, 193, 42);"></i>';
							} else {
								echo ' <i class="fa fa-circle fa-2x " style="color:#D32B2B"></i>';
							}
							?>
							</td>
							
							<td>
							<?php
							if ($pipelineDetails["last_success"] != false) {
								echo date('Y-m-d \<\b\r\> h:i:s', $pipelineDetails["last_success"]);
								echo ' #(' . $pipelineDetails["last_success_build"] . ')';
							} else {
								echo 'N/A';
							}
							?>
							</td>
							<td>
							<?php
							if ($pipelineDetails["last_fail"] != false) {
								echo date('Y-m-d \<\b\r\> h:i:s', $pipelineDetails["last_fail"]);
								echo ' #(' . $pipelineDetails["last_fail_build"] . ')';
							} else {
								echo 'N/A';
							}
							?>
							</td>
							<td>
							<?php
							if ($pipelineDetails["duration"] != false) {
								echo $pipelineDetails["duration"] . ' seconds';
							} else {
								echo 'N/A';
							}
							?>
							</td>
							<!--
							<td>
							<?php
							if ($pipelineDetails["has_parents"] === true) {
							echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=cross.png" />' ; }
							?>
							</td>
							<td>
							<?php
							if ($pipelineDetails["has_children"] === true) {
							echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=tick.png" />' ; }
							else {
							echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=cross.png" />' ; }
							?>
							</td>
							-->
							</tr>
							<?php
							$i++;
							}
							?>

							</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
	</div>
</div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/index.php?control=AssetLoader&action=show&module=BuildList&type=css&asset=buildlist.css">
<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=js&asset=buildlist.js"></script>
