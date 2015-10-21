<?php
	$date = date("F jS, Y", time() - 60 * 60 * 24);

	if (!empty($_GET['date']) && $_GET['date'] == $date) {
		$date = $_GET['date'];
		$display = "<span class='past-date'>On ". (new DateTime($date)) -> format('l, F jS')."<span>";
	} else {
		$display = "Today";
	}


	include('simple_html_dom.php');
	$html = new simple_html_dom();
	#$html -> load_file('../scrape_resource/wdi_tkl_u1 _ WD Institute Slack.html');
	$html -> load_file('assets/scrape_resource/wdi_tkl_u1 _ WD Institute Slack.html');
	$message_container = $html -> find("div[data-date='$date']", 0) -> next_sibling();


	function get_timestamps($message_container){
		while (true) {
			$user = $message_container -> find("a[class='message_sender']", 0) -> plaintext;
			$message = strtolower(current(explode(".", ($message_container -> find("span[class='message_content']", 0) -> plaintext))));

			if ((strpos($message,'break') !== false || strpos($message,'log') !== false) && strpos($user,'Trang D') !== false) {

				#if user forgot to log
				if (preg_match("/(2?[0-3]|[01]?[0-9]):[0-5][0-9]/", $message)) {

					# add meridiem indicator if user didn't specify
					if (!preg_match("/[APap][mM]/", $message)) {
						preg_match('/at ([0-9]+)\:/', $message, $matches);
						$hour =  intval($matches[1]);
						if ($hour <= 11 && $hour >= 9) {
							$message = $message." am";
						} else {
							$message = $message." pm";
						}
					}
					$timestamp = next(explode("at", $message));
				} else {
					$timestamp = $message_container -> find("a[class='timestamp']", 0) -> plaintext;
				}

				$timestamp = (new DateTime($timestamp)) -> format('h:i a');

				$messages[$timestamp] = $message;

				#exit loop if user logged out for the day
				if ((strpos($message,'log out') !== false) || strpos($message,'logged out') !== false) {
					return $messages;
				}
			}
			$message_container = $message_container -> next_sibling();
		}
	}

	function get_duration($messages){
		$timestamps = array_keys($messages);
		$duration_intervals = new DateTime('00:00');
		$duration = clone $duration_intervals;
		for ($i = 0; $i < count($timestamps); $i += 2) {
			$start_time = new DateTime($timestamps[$i]);
			$end_time = new DateTime($timestamps[$i+1]);
			$duration_interval = $start_time -> diff($end_time);
			$duration_intervals -> add($duration_interval);
		}

		$duration = $duration -> diff($duration_intervals) -> format("%H:%I");
		$duration_fraction = current(explode(":", $duration)) +  floor((intval(next(explode(":", $duration)))/60)*100)/100;
		return $duration_fraction;
	}

	function print_result($result, $today, $display){
		echo (	"<div class='result'>
					<p>".$display." you worked:</p>
					<p>".$result." hours</p>
				</div>");
	}


	$messages = get_timestamps($message_container);
	$duration_fraction = get_duration($messages);
	print_result($duration_fraction, $date, $display);
?>