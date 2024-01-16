<?php if ($response['status']) { ?>
<?php $companyName=$response['data']['companyName']; 
$websiteDomain=$response['data']['websiteDomain']; 
$countryState=$response['data']['countryState']; 
$state=$response['data']['state']; 

$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';
$idx_contact_email = isset($flex_idx_info['agent']['agent_contact_email_address']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_email_address']) : '';
?>
<style>#termsUse .ms-wrapper-section article h2 {font-weight: bold;}</style>

<div class="ms-access-content-terms">
    <h1><?php echo __('Accessibility', IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
    <p>
      <strong><?php echo $companyName; ?></strong><?php echo __(' is committed to providing an accessible website. If you have difficulty accessing content, have difficulty viewing a file on the website, or notice any accessibility problems, please contact us to ', IDXBOOST_DOMAIN_THEME_LANG); ?><strong>( <a href="mailto:<?php echo $idx_contact_email; ?>"><?php echo $idx_contact_email; ?></a> <a href="tel:<?php echo $idx_contact_phone; ?>"><?php echo $idx_contact_phone; ?></a> )</strong>
      <?php echo __('to specify the nature of the accessibility issue and any assistive technology you use. NAR will strive to provide the content you need in the format you require.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </p>
    <p>
      <strong><?php echo $companyName; ?></strong> <?php echo __('welcomes your suggestions and comments about improving ongoing efforts to increase the accessibility of this website.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </p>

    <h2><?php echo __('Accessibility Resources for Developers, Document Authors, and Contractors', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <p><?php echo __('Social Security Administration software developers and electronic content authors use a variety of accessibility guides and training materials to make the content provided on ssa.gov accessible. SSA makes these resources available as a public service to assist anyone interested in developing and authoring accessible electronic content', IDXBOOST_DOMAIN_THEME_LANG); ?>. <br><a href="https://www.ssa.gov/accessibility/andi/help/install.html" target="_blank" rel="noopener noreferrer" title="Install ANDI, Submenu Closed"><?php echo __('Install ANDI', IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
    <div class="ms-access-accordion">
      <div class="accordion-item">
        <button class="accordion-title"><?php echo __('ANDI - Web Content Accessibility Test Tool', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <div class="ms-access-content">
          <p><?php echo __('ANDI, the Accessible Name & Description Inspector is a lightweight accessibility tool you can use to check for 508 compliance as you design and develop web applications', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          <p><?php echo __('Installation is as easy as adding a favorite or bookmark', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          <p><?php echo __('ANDI is a simple interface that', IDXBOOST_DOMAIN_THEME_LANG); ?>:</p>
          <ul>
            <li><?php echo __('Automatically detects potential accessibility issues', IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
            <li><?php echo __('Discovers what a screen reader should say', IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
            <li><?php echo __('Suggests ways to improve accessibility', IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
            <li><?php echo __('Uses a design method that simplifies complex W3C specifications', IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
          </ul>
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-title"><?php echo __('Alternative Text Guide', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <div class="ms-access-content">
          <p><?php echo __('Alternative text can be applied to images, charts, diagrams, buttons, and other interface elements to convey information and purpose textually. Problems occur when alternative text is written incorrectly, confuses users, or does not provide the correct context. While the creation of alternative text is not an exact science, SSA strives to provide meaningful alternative text by following the practical guidance contained in this comprehensive reference guide', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          <a href="https://www.ssa.gov/accessibility/files/SSA_Alternative_Text_Guide.pdf" target="_blank" rel="noopener noreferrer" auto-tracked="true" title="Download Guide, Submenu Closed"><?php echo __('Download Guide', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-title"><?php echo __('Accessible Document Authoring & Testing', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <div class="ms-access-content">
          <p><?php echo __('On ssa.gov, the agency aims to provide an accessible HTML equivalent of all electronic documents provided on the site. In situations where this is not possible, the agencys goal is to provide each electronic document in an accessible format. Whereas the Section 508 accessibility standards currently do not provide specific technical guidance on what constitutes an accessible electronic document, the agency uses the following guides to author and test Word, PowerPoint, Excel and PDF documents for accessibility', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          <ul>
            <li><a href="https://www.ssa.gov/accessibility/checklists/MS_Word_508_Compliance_Checklist.pdf" target="_blank" rel="noopener noreferrer" title="Word 2013 Accessibility Checklist, Submenu Closed"><?php echo __('Word - Accessibility Checklist', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a href="https://www.ssa.gov/accessibility/checklists/PDF_508_Compliance_Checklist.pdf" target="_blank" rel="noopener noreferrer" title="PDF Accessibility Checklist, Submenu Closed"><?php echo __('PDF - Accessibility Checklist', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a href="https://www.ssa.gov/accessibility/checklists/MS_PowerPoint_508_Compliance_Checklist.pdf" target="_blank" rel="noopener noreferrer" title="PowerPoint 2016 Accessibility Checklist, Submenu Closed"><?php echo __('PowerPoint - Accessibility Checklist', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a href="https://www.ssa.gov/accessibility/checklists/MS_Excel_508_Compliance_Checklist.pdf" target="_blank" rel="noopener noreferrer" title="Excel 2016 Accessibility Checklist, Submenu Closed"><?php echo __('Excel - Accessibility Checklist', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a href="https://www.ssa.gov/accessibility/checklists/MS_Outlook_508_Compliance_Checklist.pdf" target="_blank" rel="noopener noreferrer" title="Outlook 2016 Accessibility Checklist, Submenu Closed"><?php echo __('Outlook - Accessibility Checklist', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          </ul>
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-title"><?php echo __('Resources for Contractors', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <div class="ms-access-content">
          <p><?php echo __('Social Security Administration applies the Section 508 standards and other accessibility terms and conditions when we purchase information technology and communications products and services. The following information is provided to assist prospective vendors with responding to solicitations and with product design and development activities', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          <a href="https://www.ssa.gov/accessibility/contractor_resources.html" target="_blank" title="Contractor Resources, Submenu Closed"><?php echo __('Contractor Resources', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
  jQuery(document).on('click', '.accordion-title', function() {
    var $item = jQuery(this);

    if ($item.hasClass('active')) {
      $item.removeClass('active');
      $item.next().removeClass('active');
    } else {
      $item.addClass('active');
      $item.next().addClass('active');
    }
  })
</script>


<?php } ?>