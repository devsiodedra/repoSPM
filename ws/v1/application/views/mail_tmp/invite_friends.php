<table style="border-left:thin #17c5cb solid; border-right:thin #17c5cb solid; border-bottom:thin #17c5cb solid;" bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
    <tbody>
        <tr>
            <td width="100%" height="20">
            </td>
        </tr>
        <tr>
            <td>
                <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                    <tbody>
                        <!-- title -->

                        <tr>
                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:left;line-height: 20px;">
                                <p>
                                    <?= $user['first_name'] . ' ' . $user['last_name'] ?> invited you to join <?= APP_NAME?>
                                </p>
                            </td>
                        </tr>
                        <!-- end of title -->

                        <!-- Spacing -->

                        <tr>
                            <td width="100%" height="10">
                            </td>
                        </tr>
                        <!-- Spacing -->

                        <!-- content -->

                        <tr>
                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #666666; text-align:left;line-height: 24px;">
                                <p>
                                    <?php
                                    if ($msg) {
                                        echo '<b>' . $msg . '</b><br /><br />';
                                    }
                                    ?>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                </p>
                            </td>
                        </tr>
                        <!-- end of content -->

                        <!-- Spacing -->

                        <tr>
                            <td width="100%" height="10">
                            </td>
                        </tr>
                        <!-- button -->

                        <tr>
                            <td>
                                <div class="buttonbg">
                                </div>
                                <table height="30" align="left" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" style=" background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px;">
                                    <tbody>
                                        <tr>
                                            <td style="padding-left:18px; padding-right:18px;font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300;" width="auto" align="center" valign="middle" height="30">
                                                <span style="color: #ffffff; font-weight: 300;"> <a style="color: #ffffff; text-align:center;text-decoration: none;" href="<?= site_url('?ref=' . sha1($user['user_id'])) ?>" tabindex="-1">Join Now</a></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- /button -->

                        <!-- Spacing -->

                        <tr>
                            <td width="100%" height="20">
                            </td>
                        </tr>
                        <!-- Spacing -->

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>