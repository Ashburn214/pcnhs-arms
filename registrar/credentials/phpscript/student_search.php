<?php
	require_once "../../../resources/config.php";
	$search = $_GET['query'];

	$query = "SELECT * from students left join curriculum on students.curr_id = curriculum.curr_id where last_name like '$search%' or first_name like '$search%';";

	$result = DB::query($query);
	if (count($result) > 0) {
		foreach ($result as $row) {
			$stud_id = $row['stud_id'];
			$full_name = $row['first_name'].' '.$row['last_name'];

			$response[] = array(
				'name' => "$full_name",
			);
		}
	}else {
		$response[] = array(
				'name' => "No student found.",
		);
	}

	echo json_encode($response);

?>
