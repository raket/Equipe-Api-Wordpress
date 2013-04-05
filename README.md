Equipe-Api-Wordpress
====================

A Wordpress plugin to integrate to Equipes Api

Set the competition ID in wp-admin under "Settings->Equipe-Api"

After that you can use tha plugin as a Wp_query object.

Examples
====================

Create an Equipe Object
--------------

	$Equipe = new Equipe();


Get Timeschedule
--------------

	$Equipe->get_timeschedule();

	while($Equipe->have_days()): $day = $Equipe->the_day();

    	echo $day->date_description;

	endwhile;


Get Timeschedule
--------------
*Takes Class ID*

	$Equipe->get_startlist($class_id);

	while($Equipe->startlist_have_riders()): $rider = $Equipe->startlist_the_rider();

    	echo $rider->rider_name;

	endwhile;



Get Resultlist
--------------
*Takes Class ID*

	$Equipe->get_resultlist($class_id);

	while($Equipe->resultlist_have_riders()): $rider = $Equipe->resultlist_the_rider();

    	echo $rider->rider_name;

	endwhile;


Get Riders
--------------
*Takes Class ID*

	$Equipe->get_riders($meeting_id);
	while($Equipe->have_riders()): $rider = $Equipe->the_rider();

    	echo $rider->name;

	endwhile;


Get Horses
--------------
*Takes Class ID*

	$Equipe->get_horses($meeting_id);
	while($Equipe->have_horses()): $horse = $Equipe->the_horse();

    	echo $horse->name;

	endwhile;
	

Get Horse
--------------	
*Takes Meeting ID, Horse ID*

	$horse = $Equipe->get_horse($rider->meeting_id, $rider->horse_id);


Get Starts 
--------------
*Takes svrf_nr, $args*

	$Equipe->get_club_starts($svrf_nr, $args);
	while($Equipe->have_starts()): $start = $Equipe->the_start();

    	echo $start->rider_name;

	endwhile;
