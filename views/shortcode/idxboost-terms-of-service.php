<?php if ($response['status']) { ?>
<?php $companyName=$response['data']['companyName']; 
$websiteDomain=$response['data']['websiteDomain']; 
$countryState=$response['data']['countryState']; 
$state=$response['data']['state']; 

$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';
$idx_contact_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_email_address']) : '';

?>
<!--  
  <STYLE TYPE="text/css">
    @page { size: 8.5in 11in; margin: 1in }
    #clidxboost-terms-policy p { margin-bottom: 0.08in; border: none; padding: 0in; direction: ltr; color: #000000; widows: 2; orphans: 2 }
    #clidxboost-terms-policy p.western { font-family: "Arial", serif; so-language: en }
    #clidxboost-terms-policy p.cjk { font-family: "Arial" }
    #clidxboost-terms-policy p.ctl { font-family: "Arial" }
    #clidxboost-terms-policy a:link { color: #0000ff; so-language: zxx }
    main#clidxboost-terms-policy li { list-style: inherit; }    
  </STYLE>
-->
<div class="r-overlay"></div>

<main id="clidxboost-terms-policy">

  <h2 class="clidxboost-tp-title"><?php echo __("TERMS AND CONDITIONS", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>

  <ul class="clidxboost-terms-tab-nav">
    <li><a href="#atospp-terms" data-section="#atospp-terms"><?php echo __("Terms of Service", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
    <li><a href="#atospp-privacy" data-section="#atospp-privacy"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
  </ul>

  <div id="atospp-terms">
    <h3><?php echo __("Terms of Service", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>
    <p>Last updated: <?php echo date("m/d/Y"); ?></p>
    <p>Please read these Terms of Use ("Terms", "Terms of Use") carefully before using the <?php echo $websiteDomain; ?> website (the "Service") operated by <?php echo $companyName; ?> ("us", "we", or "our").</p>
    <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms.These Terms apply to all visitors, users and others who access or use the Service.</p>
    <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not be granted or access the Service.</p>

    <h3><?php echo __("Accounts", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>

    <p>When you create an account with us, you must provide us information that is accurate, complete, and up to date at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>
    <p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>
    <p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account .</p>

    <h3><?php echo __("Intellectual Property", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>
    <p>The Service and its original content, features and functionality are and will remain the exclusive property of <?php echo $companyName; ?> and its licensors.</p>

    <h3><?php echo __("Links To Other Websites", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>
    <p>Our Service may contain links to third-party websites or services that are not owned or controlled by <?php echo $companyName; ?>.</p>
    
    <p><?php echo $companyName; ?> has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party websites or services. You further acknowledge and agree that <?php echo $companyName; ?> shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such websites or services.</p>

    <p>We strongly advise you to read the terms and conditions and privacy policies of any third-party websites or services that you visit.</p>

    <h3><?php echo __("IDX OR MLS LISTING IMAGES", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>

    <p>IDX OR MLS Listing Images. <?php echo $companyName; ?> shall hold no liability or responsibility with respect to images and content on <?php echo $companyName; ?> website, and shall be released and held harmless with respect to any problem that may arise from images that are outside the control of <?php echo $companyName; ?>.  In the event of an issue or problem with images or content placed on <?php echo $companyName; ?>’s website, which appear as a result of MLS/IDX listings or via any third party, Any IDX or MLS LISTING IMAGE legal matters should be dealt with the third party that placed such image or content on the IDX od MLS system.As such, Anyone that is looking for legal compensation shall indemnify and hold <?php echo $companyName; ?> and its affiliates harmless from and against any and all losses, liabilities, claims, charges, actions, proceedings, demands, judgments, settlements, costs and expenses (including, without limitation, fees and expenses of counsel) which any of <?php echo $companyName; ?> or its affiliates may incur as a result of or arising in any way out of <?php echo $companyName; ?>’s use of the IDX/MLS listings.</p>

    <h3><?php echo __("Termination", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
    <p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>
    <p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>

    <h3><?php echo __("Disclaimer", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS AVAILABLE" basis. The Service is provided without warranties of any kind, whether express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, non-infringement or course of performance.</p>

    <h3><?php echo __("Governing Law", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>These Terms shall be governed and construed in accordance with the laws of <?php echo $countryState; ?> without regard to its conflict of law provisions.</p>
    <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>

    <h3><?php echo __("Changes", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 15 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
    <p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please refrain on using the Service.</p>

    <h3><?php echo __("Contact Us", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>If you have any questions about these Terms, please contact us.</p>
  </div>

  <div id="atospp-privacy">
    <h3><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?>:</h3>
    <p>Last updated: <?php echo date("m/d/Y"); ?></p>
    <p><?php echo $companyName; ?> ("us", "we", or "our") operates the <?php echo $websiteDomain; ?> website (the "Service").This page informs you of our policies regarding the collection, use and disclosure of Personal Information when you use our Service.</p>
    <p>We will not use or share your information with anyone except as described in this Privacy Policy.</p>
    <p>We use your Personal Information for providing and improving the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible at <?php echo $websiteDomain; ?></p>
  </div>

  <div id="follow-up-boss">
    <h3><?php echo __("Information Collection And Use", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information ("Personal Information") may include, but is not limited to:</p>
    <ul>
      <li>Name</li>
      <li>Email address</li>
      <li>Telephone number</li>
      <li>Address</li>
    </ul>

    <h3><?php echo __("We use this information to", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <ul>
      <li>Send you requested product or service information</li>
      <li>Respond to customer service requests</li>
      <li>Administer your account</li>
      <li>Send you a newsletter</li>
      <li>Send you marketing communications</li>
      <li>Improve our Web site and marketing efforts</li>
      <li>Conduct research and analysis</li>
      <li>Display content based upon your interests</li>
    </ul>
    <p>By clicking the Submit button, you agree to have your information shared with us and for us to contact you via telephone, mobile phone (including through automated dialing, text SMS/MMS, or pre-recorded messaging) and/or email, even if your telephone number is on a corporate, state, or the National Do Not Call Registry, and you agree to our Privacy Policy.</p>
    <p>To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails.</p>
  </div>

  <div id="notice-privacy">
    <h3><?php echo __("Notice to California Residents", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>If you are a resident of California, then the collection, processing and use of your personal information may be subject to the California Consumer Privacy Act (“CCPA”) as well as other applicable California state privacy laws.</p>
    <p>As a company that does business in California and collects the personal information of some California residents, we are required to inform you of the consumer rights afforded to you under the CCPA, and to enable you to exercise those rights with regards to any personal information that we may have collected about you.</p>

    <h3><?php echo __("Log Data", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We collect information that your browser sends whenever you visit our Service ("Log Data"). This Log Data may include information such as your computer's Internet Protocol ("IP") address, browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages and other statistics.</p>

    <h3><?php echo __("Ads Using Third Party Vendors", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>Google,Facebook and other social media platforms as third-party vendors, use cookies to serve ads on our Service.</p>

    <h3><?php echo __("Cookies", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>Cookies are files with a small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive.</p>
    <p>We use "cookies" to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>

    <h3><?php echo __("Service Providers", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We may employ third party companies and individuals to facilitate our Service, to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>
    <p>These third parties have access to your Personal Information only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>

    <h3><?php echo __("Security", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.</p>

    <h3><?php echo __("Links To Other Sites", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>Our Service may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site you visit.</p>
    <p>We have no control over, and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>


    <h3><?php echo __("Children's Privacy", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>Our Service does not address anyone under the age of 18 ("Children").</p>
    <p>We do not knowingly collect personally identifiable information from children under 18. If you are a parent or guardian and you are aware that your child has provided us with Personal Information, please contact us. If we discover that a child under 18 has provided us with Personal Information, we will delete such information from our servers immediately.</p>

    <h3><?php echo __("Compliance With Laws", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We will disclose your Personal Information where required to do so by law or subpoena.</p>

    <h3><?php echo __("Changes To This Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>
    <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>

    <h3><?php echo __("Contact Us", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    <p>If you have any questions regarding the Privacy Policy, please call us at <a href="tel:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>"><?php echo $idx_contact_phone; ?></a> or send us an email to <a href="mailto:<?php echo $idx_contact_email; ?>"><?php echo $idx_contact_email; ?></a>.</p>
    <p><a href="#atospp-terms"><?php echo __("Back to top", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
  </div>

</main>
<?php } ?>