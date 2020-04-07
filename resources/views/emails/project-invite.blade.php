<?php

echo '<h1>Hello ' . $projectInvitationData['recipientName'] . '</h1><br>';

echo '<h3>' . $projectInvitationData['senderName'] . ' invited you to join his project ' . $projectInvitationData['projectName'] . '<br>';

echo '<a href="/invitation"><buttton>View invitation</button></a>';
