<!-- Section -->
     
      <table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">
        <tr>
          <td class="sectionEven">
            <table border="0" cellpadding="0" cellspacing="0" width="640" align="center" summary="">
             
                      <tr>
                            <td>
                                <p>
                                     You’re almost there! Just confirm your email.
                                </p><br/>
                                <p>
                                     You have successfully created account for <?= $email; ?> with iDoc Academy.
                                </p>
                                <p>
                                     To activate it, please click below to verify your email address.
                                </p>
                            </td>
                        </tr>
                       
                      <tr>
                       <td class="buttonContainer">
                          <table border="0" cellpadding="0" cellspacing="0" summary="" width="30%" align="center">
                            <tr>
                              <td class="button" style="padding: 10px 5px 10px 5px; text-align: center; background-color: #826fea; border-radius: 4px;">
                              <span style="color: #ffffff; font-weight: 300;"> <a style="color: #ffffff; text-align:center;text-decoration: none;" href="<?= base_url('api/verify/' . sha1($user_id)) ?>" tabindex="-1">Activate Your Account</a></span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
            </table>
          </td>
        </tr>
      </table>

      <!-- End Section -->