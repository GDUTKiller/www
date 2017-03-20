<?php
function encCookie($user_id, $username) {
    return md5($user_id . '|' . $username . '|' . C('COO_KEY'));
}