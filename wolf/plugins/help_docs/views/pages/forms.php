<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/**
 * The help_docs plugin serves as a basic plugin template.
 *
 * This help_docs plugin makes use/provides the following features:
 * - A controller without a tab
 * - Three views (sidebar, documentation and settings)
 * - A documentation page
 * - A sidebar
 * - A settings page (that does nothing except display some text)
 * - Code that gets run when the plugin is enabled (enable.php)
 *
 * Note: to use the settings and documentation pages, you will first need to enable
 * the plugin!
 *
 * @package wolf
 * @subpackage plugin.help_docs
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @version 1.0.0
 * @since Wolf version 0.5.5
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Martijn van der Kleijn, 2008
 */
?>
<div class="box help">
<!-- <h1><?php echo __('Forms'); ?></h1> -->

<p>Forms should be embedded one per page with page type set to 'Form'.</p>
<code>contactForm(clientemail(&#36;this),clientname(),'Enquiry','&#60;h2>Send us a message&#60;/h2>',true,'Send now',$this)</code>

<p>To place mutiple forms on a page, each form that is not itself a form page (such as embedded in sidebar of multiple pages), should explicitly redirect to it's appointed form page.</p>
<code>contactForm(clientemail(&#36;this),clientname(),'Enquiry','&#60;h2>Send us a message&#60;/h2>',true,'Send now',&#36;this,'<?php echo URL_ABSOLUTE; ?>contact/email.html',true)</code>




<h2 id="appointmentForm">Appointment Form</h2>
<p>Example 1 Displays appointment form with form heading.</p>
<code>appointmentForm('info@clientwebsite.com','Client Website','Appointment','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays appointment form without heading.</p>
<code>appointmentForm('info@clientwebsite.com','Client Website','Appointment','',true,'text',$this)</code>
<p>Example 3 Displays appointment form without heading, uses image for submit button and does not display form after sending.</p>
<code>appointmentForm('info@clientwebsite.com','Client Website','Appointment','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays appointment form with specific post URL.</p>
<code>appointmentForm('info@clientwebsite.com','Client Website','Appointment','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="callbackForm">Callback Form</h2>
<p>Example 1 Displays callback form with form heading.</p>
<code>callbackForm('info@clientwebsite.com','Client Website','Callback','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays callback form without heading.</p>
<code>callbackForm('info@clientwebsite.com','Client Website','Callback','',true,'text',$this)</code>
<p>Example 3 Displays callback form without heading, uses image for submit button and does not display form after sending.</p>
<code>callbackForm('info@clientwebsite.com','Client Website','Callback','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays callback form with specific post URL.</p>
<code>callbackForm('info@clientwebsite.com','Client Website','Callback','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="consultationForm">Consultation Form</h2>
<p>There are two available consultation form plugins. <a href="/<?php echo ADMIN_DIR; ?>/setting#plugins">Choose one</a> and disable the other.</p>
<p>Example 1 Displays consultation form with form heading.</p>
<code>consultationForm('info@clientwebsite.com','Client Website','Consultation','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays consultation form without heading.</p>
<code>consultationForm('info@clientwebsite.com','Client Website','Consultation','',true,'text',$this)</code>
<p>Example 3 Displays consultation form without heading, uses image for submit button and does not display form after sending.</p>
<code>consultationForm('info@clientwebsite.com','Client Website','Consultation','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays consultation form with specific post URL.</p>
<code>consultationForm('info@clientwebsite.com','Client Website','Consultation','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="contactForm">Contact Form</h2>
<p>Example 1 Displays contact form with form heading.</p>
<code>contactForm('info@clientwebsite.com','Client Website','Contact enquiry','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays contact form without heading.</p>
<code>contactForm('info@clientwebsite.com','Client Website','Contact enquiry','',true,'text',$this)</code>
<p>Example 3 Displays contact form without heading, uses image for submit button and does not display form after sending.</p>
<code>contactForm('info@clientwebsite.com','Client Website','Contact enquiry','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays contact form without heading with specific post URL.</p>
<code>contactForm('info@clientwebsite.com','Client Website','Contact enquiry','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="friendForm">Refer a friend Form</h2>
<p>Example 1 Displays refer a friend form with chosen subject title and form heading.</p>
<code>friendForm('Check out this great subject title','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays refer a friend form without heading and submit labelled 'Send now'.</p>
<code>friendForm('Check out this great subject title','',true,'Send now',$this)</code>
<p>Example 3 Displays refer a friend form without heading, does not display form after sending and uses image for submit button.</p>
<code>friendForm('Check out this great subject title','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays refer a friend form with specific post URL.</p>
<code>friendForm('Check out this great subject title','','','Send now',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="informationForm">Information Form</h2>
<p>Example 1 Displays information evening form with form heading.</p>
<code>informationForm('info@clientwebsite.com','Client Website','Information evening enquiry','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays information evening form without heading.</p>
<code>informationForm('info@clientwebsite.com','Client Website','Information evening enquiry','',true,'text',$this)</code>
<p>Example 3 Displays information evening form without heading, uses image for submit button and does not display form after sending.</p>
<code>informationForm('info@clientwebsite.com','Client Website','Information evening enquiry','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays information evening form with specific post URL.</p>
<code>informationForm('info@clientwebsite.com','Client Website','Information evening enquiry','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="consultationForm">Pre-registration Form</h2>
<p>Example 1 Displays pre-registration form with form heading.</p>
<code>preregistrationForm('info@clientwebsite.com','Client Website','Pre-registration enquiry','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays pre-registration form without heading.</p>
<code>preregistrationForm('info@clientwebsite.com','Client Website','Pre-registration enquiry','',true,'text',$this)</code>
<p>Example 3 Displays pre-registration form without heading, uses image for submit button and does not display form after sending.</p>
<code>preregistrationForm('info@clientwebsite.com','Client Website','Pre-registration enquiry','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays pre-registration form with specific post URL.</p>
<code>preregistrationForm('info@clientwebsite.com','Client Website','Pre-registration enquiry','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="questionForm">Question Form</h2>
<p>Example 1 Displays question form with form heading.</p>
<code>questionForm('info@clientwebsite.com','Client Website','Question','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays question form without heading.</p>
<code>questionForm('info@clientwebsite.com','Client Website','Question','',true,'text',$this)</code>
<p>Example 3 Displays question form without heading, uses image for submit button and does not display form after sending.</p>
<code>questionForm('info@clientwebsite.com','Client Website','Question','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays question form with specific post URL.</p>
<code>questionForm('info@clientwebsite.com','Client Website','Question','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="referralForm">Referral Form</h2>
<p>Example 1 Displays referral form with form heading.</p>
<code>referralForm('info@clientwebsite.com','Client Website','Referral','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays referral form without heading.</p>
<code>referralForm('info@clientwebsite.com','Client Website','Referral','',true,'text',$this)</code>
<p>Example 3 Displays referral form without heading, uses image for submit button and does not display form after sending.</p>
<code>referralForm('info@clientwebsite.com','Client Website','Referral','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays referral form with additional treatment options set to true.</p>
<code>referralForm('info@clientwebsite.com','Client Website','Referral','',false,'/inc/img/submit.gif',$this,true)</code>
<p>Example 5 Displays referral form with specific post URL.</p>
<code>referralForm('info@clientwebsite.com','Client Website','Referral','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="requestForm">(Brochure) Request Form</h2>
<p>Example 1 Displays request form with form heading.</p>
<code>requestForm('info@clientwebsite.com','Client Website','(Brochure) request','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays request form without heading.</p>
<code>requestForm('info@clientwebsite.com','Client Website','(Brochure) request','',true,'text',$this)</code>
<p>Example 3 Displays request form without heading, uses image for submit button and does not display form after sending.</p>
<code>requestForm('info@clientwebsite.com','Client Website','(Brochure) request','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays request form with specific post URL.</p>
<code>requestForm('info@clientwebsite.com','Client Website','(Brochure) request','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

<h2 id="techfeedbackForm">Tech Feedback Form</h2>
<p>Example 1 Displays feedback form with form heading.</p>
<code>techfeedbackForm('info@clientwebsite.com','Client Website','Feedback','Form Heading',true,'text',$this)</code>
<p>Example 2 Displays feedback form without heading.</p>
<code>techfeedbackForm('info@clientwebsite.com','Client Website','Feedback','',true,'text',$this)</code>
<p>Example 3 Displays feedback form without heading, uses image for submit button and does not display form after sending.</p>
<code>techfeedbackForm('info@clientwebsite.com','Client Website','Feedback','',false,'/inc/img/submit.gif',$this)</code>
<p>Example 4 Displays feedback form with specific post URL.</p>
<code>techfeedbackForm('info@clientwebsite.com','Client Website','Feedback','','','',$this,'<?php echo URL_ABSOLUTE; ?>contact/form.php',true)</code>

</div>
