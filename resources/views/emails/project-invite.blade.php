<?php

echo '<h1>Hello ' . $projectInvitationData['recipientName'] . '</h1><br>';

echo '<h3>' . $projectInvitationData['senderName'] . ' invited you to join his project ' . $projectInvitationData['projectName'] . '<br>';

echo '<a href="http://website-health.checker.test/invitation/' . $projectInvitationData['projectSlug'] . '/' . $projectInvitationData['recipientSlug'] . '/' . $projectInvitationData['token'] . '"><buttton>View invitation</button></a>';
