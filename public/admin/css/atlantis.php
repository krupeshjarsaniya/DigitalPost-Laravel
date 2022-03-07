<?php 
header('Content-type: text/css');
header('Cache-control: must-revalidate');
?>
<style type="text/css" media="screen">
/*!

 =========================================================
 * Atlantis Bootstrap 4 Admin Dashboard (Bootstrap 4)
 =========================================================

 * Product Page: http://www.themekita.com/
 * Copyright 2018 Theme Kita (http://www.themekita.com/)

 =========================================================

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

[Table of contents]

* Background
* Typography
* Layouts
   + Body & Wrapper
   + Main Header
   + Sidebar
* Layouts Color
* Components
   + Breadcrumbs
   + Cards
     - Card Stats
     - Card Task
     - Card States
     - Card Posts
     - Card Pricing
     - Card Annoucement
     - Card Profile
     - Accordion
   + Inputs
   + Tables
   + Navbars
   + Navsearch
   + Badges
   + Dropdowns
   + Charts
   + Alerts
   + Buttons
   + Navtabs
   + Popovers
   + Progress
   + Paginations
   + Sliders
   + Modals
   + Timeline
   + Maps
   + Invoice
   + Messages
   + Tasks
   + Settings
* Plugins
   + jQueryUI
   + jQuery Scrollbar
   + Toggle
   + Css Animate
   + Full Calendar
   + SweetAlert
   + Datatables
   + DateTimePicker
   + Select2
   + Tagsinput
   + Dropzone
   + Summernote
* Responsive
* 404
* Login & Register

# [Color codes]

body-text-color: #575962
white-color: #ffffff
black-color: #191919
transparent-bg : transparent
default-color : #282a3c
primary-color : #177dff
secondary-color : #716aca
info-color : #36a3f7
success-color : #35cd3a
warning-color : #ffa534
danger-color : #f3545d

-------------------------------------------------------------------*/
*:focus {
  outline: 0 !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important; }

/*   Typography    */
body, h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, p, .navbar, .brand, .btn-simple, .alert, a, .td-name, td, button.close {
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  font-family: 'Lato', sans-serif; }

body {
  font-size: 14px;
  letter-spacing: 0.05em;
  color: #2A2F5B; }

a {
  color: #1572E8; }
  a:hover, a:focus {
    color: #1269DB; }

h1,
.h1 {
  font-size: 1.725rem; }

h2,
.h2 {
  font-size: 1.35rem; }

h3,
.h3 {
  font-size: 1.1625rem; }

h4,
.h4 {
  font-size: 1.0375rem; }

h5,
.h5 {
  font-size: .9125rem; }

h6,
.h6 {
  font-size: .825rem; }

p {
  font-size: 14px;
  line-height: 1.82;
  margin-bottom: 1rem;
  word-break: break-word; }

h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
  line-height: 1.4; }
  h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .h1 a, .h2 a, .h3 a, .h4 a, .h5 a, .h6 a {
    color: inherit; }

small, .small {
  font-size: 13px; }

b, .b, strong, .strong {
  font-weight: 600; }

.page-pretitle {
  letter-spacing: .08em;
  text-transform: uppercase;
  color: #95aac9; }

.page-title {
  font-size: 23px;
  font-weight: 600;
  color: #444444;
  line-height: 30px;
  margin-bottom: 20px; }

.page-category {
  color: #444444;
  line-height: 1.8;
  margin-bottom: 25px; }

.text-primary, .text-primary a {
  color: #1572E8 !important; }
  .text-primary:hover, .text-primary a:hover {
    color: #1572E8 !important; }

.text-secondary, .text-secondary a {
  color: #6861CE !important; }
  .text-secondary:hover, .text-secondary a:hover {
    color: #6861CE !important; }

.text-info, .text-info a {
  color: #48ABF7 !important; }
  .text-info:hover, .text-info a:hover {
    color: #48ABF7 !important; }

.text-success, .text-success a {
  color: #31CE36 !important; }
  .text-success:hover, .text-success a:hover {
    color: #31CE36 !important; }

.text-warning, .text-warning a {
  color: #FFAD46 !important; }
  .text-warning:hover, .text-warning a:hover {
    color: #FFAD46 !important; }

.text-danger, .text-danger a {
  color: #F25961 !important; }
  .text-danger:hover, .text-danger a:hover {
    color: #F25961 !important; }

label {
  color: #495057 !important;
  font-size: 14px !important; }

.text-small {
  font-size: 11px; }

.metric-value {
  margin-bottom: 5px;
  line-height: 1;
  white-space: nowrap; }

.metric-label {
  font-size: .975rem;
  font-weight: 500;
  color: #686f76;
  white-space: nowrap;
  margin-bottom: 0; }

/*   Font-weight    */
.fw-light {
  font-weight: 300 !important; }

.fw-normal {
  font-weight: 400 !important; }

.fw-mediumbold {
  font-weight: 400 !important; }

.fw-bold {
  font-weight: 600 !important; }

.fw-extrabold {
  font-weight: 700 !important; }

/* 		Opacity  	*/
.op-9 {
  opacity: 0.9; }

.op-8 {
  opacity: 0.8; }

.op-7 {
  opacity: 0.7; }

.op-6 {
  opacity: 0.6; }

.op-5 {
  opacity: 0.5; }

.op-4 {
  opacity: 0.4; }

.op-3 {
  opacity: 0.3; }

/*    Layouts     */
body {
  min-height: 100vh;
  position: relative;
  background: #f9fbfd;
  background-size: cover;
  background-attachment: fixed;
  background-repeat: no-repeat; }

.border-left, .border-right, .border-bottom, .border-top {
  border-color: #F0F1F3 !important; }

.no-box-shadow {
  box-shadow: none !important; }

/*    margin-top negative   */
.mt--5, .my--5 {
  margin-top: -3rem !important; }

.mt--4, .my--4 {
  margin-top: -1.5rem !important; }

.mt--3, .my--3 {
  margin-top: -1rem !important; }

.mt--2, .my--2 {
  margin-top: -0.5rem !important; }

.mt--1, .my--1 {
  margin-top: -0.25rem !important; }

/*      Wrapper      */
.pull-right {
  float: right; }

.pull-left {
  float: left; }

.wrapper {
  min-height: 100vh;
  position: relative;
  top: 0;
  height: 100vh; }

.main-header {
  background: #ffffff;
  min-height: 60px;
  width: 100%;
  position: fixed;
  z-index: 1001;
  box-shadow: 0px 0px 5px rgba(18, 23, 39, 0.5); }
  .main-header .navbar-header {
    min-height: 62px; }
    .main-header .navbar-header .btn-toggle {
      margin-right: 30px;
      margin-left: 20px; }

.logo-header {
  float: left;
  width: 250px;
  height: 62px;
  line-height: 60px;
  color: #333333;
  z-index: 1001;
  font-size: 17px;
  font-weight: 400;
  padding-left: 25px;
  padding-right: 25px;
  z-index: 1001;
  display: flex;
  align-items: center;
  position: relative;
  transition: all .3s; }
  .logo-header .big-logo {
    margin-right: 8px; }
    .logo-header .big-logo:hover {
      text-decoration: none; }
    .logo-header .big-logo .logo-img {
      width: 35px;
      height: 35px; }
  .logo-header .logo {
    color: #2A2F5B;
    opacity: 1;
    position: relative;
    height: 100%; }
    .logo-header .logo:hover {
      text-decoration: none; }
    .logo-header .logo .navbar-brand {
      padding-top: 0px;
      padding-bottom: 0px;
      margin-right: 0px; }
  .logo-header .nav-toggle {
    position: absolute;
    top: 0;
    right: 18px;
    z-index: 5; }
  .logo-header .navbar-toggler {
    padding-left: 0px;
    padding-right: 0px;
    opacity: 0;
    display: none; }
    .logo-header .navbar-toggler .navbar-toggler-icon {
      height: 1em;
      width: 1em;
      color: #545454;
      font-size: 22px; }
  .logo-header .more {
    background: transparent;
    border: 0;
    font-size: 22px;
    padding: 0;
    opacity: 0;
    width: 0;
    display: none; }

.btn-toggle {
  font-size: 20px !important;
  line-height: 20px;
  padding: 0px !important;
  background: transparent !important;
  color: #2A2F5B !important; }
  .btn-toggle:hover, .btn-toggle:focus {
    opacity: 1; }

#search-nav {
  flex: 1;
  max-width: 300px;
  transition: all .4s; }
  #search-nav.focus {
    max-width: 400px; }

.sidebar .nav > .nav-item.active > a:before, .sidebar[data-background-color="white"] .nav > .nav-item.active > a:before, .sidebar .nav > .nav-item.active:hover > a:before, .sidebar[data-background-color="white"] .nav > .nav-item.active:hover > a:before, .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
  opacity: 1 !important;
  position: absolute;
  z-index: 1;
  width: 3px;
  height: 100%;
  content: '';
  left: 0;
  top: 0; }

.sidebar, .sidebar[data-background-color="white"] {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  width: 250px;
  margin-top: 62px;
  display: block;
  z-index: 1000;
  color: #ffffff;
  font-weight: 200;
  background: #ffffff;
  -webkit-box-shadow: 4px 4px 10px rgba(69, 65, 78, 0.06);
  -moz-box-shadow: 4px 4px 10px rgba(69, 65, 78, 0.06);
  box-shadow: 4px 4px 10px rgba(69, 65, 78, 0.06);
  transition: all .3s; }
  .sidebar.full-height, .sidebar[data-background-color="white"].full-height {
    margin-top: 0; }
  .sidebar .user, .sidebar[data-background-color="white"] .user {
    padding-top: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 15px;
    border-top: 1px solid #f1f1f1;
    border-bottom: 1px solid #f1f1f1;
    display: block;
    margin-left: 15px;
    margin-right: 15px; }
    .sidebar .user .info a, .sidebar[data-background-color="white"] .user .info a {
      white-space: nowrap;
      display: block;
      position: relative; }
      .sidebar .user .info a:hover, .sidebar .user .info a:focus, .sidebar[data-background-color="white"] .user .info a:hover, .sidebar[data-background-color="white"] .user .info a:focus {
        text-decoration: none; }
      .sidebar .user .info a > span, .sidebar[data-background-color="white"] .user .info a > span {
        font-size: 14px;
        font-weight: 400;
        color: #777;
        display: flex;
        flex-direction: column; }
        .sidebar .user .info a > span .user-level, .sidebar[data-background-color="white"] .user .info a > span .user-level {
          color: #555;
          font-weight: 600;
          font-size: 12px;
          margin-top: 5px; }
      .sidebar .user .info a .link-collapse, .sidebar[data-background-color="white"] .user .info a .link-collapse {
        padding: 7px 0; }
    .sidebar .user .info .caret, .sidebar[data-background-color="white"] .user .info .caret {
      position: absolute;
      top: 17px;
      right: 0px;
      border-top-color: #777; }
  .sidebar .sidebar-wrapper, .sidebar[data-background-color="white"] .sidebar-wrapper {
    position: relative;
    max-height: calc(100vh - 75px);
    min-height: 100%;
    overflow: auto;
    width: 100%;
    z-index: 4;
    padding-bottom: 100px;
    transition: all .3s; }
    .sidebar .sidebar-wrapper .sidebar-content, .sidebar[data-background-color="white"] .sidebar-wrapper .sidebar-content {
      padding-top: 0px;
      padding-bottom: 55px; }
    .sidebar .sidebar-wrapper .scroll-element.scroll-y, .sidebar[data-background-color="white"] .sidebar-wrapper .scroll-element.scroll-y {
      top: 5px !important; }
  .sidebar .nav, .sidebar[data-background-color="white"] .nav {
    display: block;
    float: none;
    margin-top: 20px; }
    .sidebar .nav .nav-section, .sidebar[data-background-color="white"] .nav .nav-section {
      margin: 15px 0 0 0; }
      .sidebar .nav .nav-section .sidebar-mini-icon, .sidebar[data-background-color="white"] .nav .nav-section .sidebar-mini-icon {
        text-align: center;
        font-size: 15px;
        color: #909093;
        display: none; }
      .sidebar .nav .nav-section .text-section, .sidebar[data-background-color="white"] .nav .nav-section .text-section {
        padding: 2px 30px;
        font-size: 12px;
        color: #727275;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        margin-top: 20px; }
    .sidebar .nav > .nav-item, .sidebar[data-background-color="white"] .nav > .nav-item {
      display: list-item; }
      .sidebar .nav > .nav-item.active > a, .sidebar[data-background-color="white"] .nav > .nav-item.active > a {
        color: #2A2F5B !important; }
        .sidebar .nav > .nav-item.active > a:before, .sidebar[data-background-color="white"] .nav > .nav-item.active > a:before {
          background: #1d7af3; }
        .sidebar .nav > .nav-item.active > a p, .sidebar[data-background-color="white"] .nav > .nav-item.active > a p {
          color: #2A2F5B !important;
          font-weight: 600; }
      .sidebar .nav > .nav-item.active:hover > a:before, .sidebar[data-background-color="white"] .nav > .nav-item.active:hover > a:before {
        background: #1d7af3; }
      .sidebar .nav > .nav-item.active a i, .sidebar[data-background-color="white"] .nav > .nav-item.active a i {
        color: #4d7cfe; }
      .sidebar .nav > .nav-item.submenu, .sidebar[data-background-color="white"] .nav > .nav-item.submenu {
        background: rgba(0, 0, 0, 0.03); }
        .sidebar .nav > .nav-item.submenu > li > a i, .sidebar[data-background-color="white"] .nav > .nav-item.submenu > li > a i {
          color: rgba(23, 125, 255, 0.76); }
      .sidebar .nav > .nav-item > a:hover, .sidebar .nav > .nav-item a:focus, .sidebar[data-background-color="white"] .nav > .nav-item > a:hover, .sidebar[data-background-color="white"] .nav > .nav-item a:focus {
        background: rgba(0, 0, 0, 0.03); }
      .sidebar .nav > .nav-item a, .sidebar[data-background-color="white"] .nav > .nav-item a {
        display: flex;
        align-items: center;
        color: #575962;
        padding: 6px 25px;
        width: 100%;
        font-size: 14px;
        font-weight: 400;
        position: relative;
        margin-bottom: 3px; }
        .sidebar .nav > .nav-item a:hover, .sidebar .nav > .nav-item a:focus, .sidebar[data-background-color="white"] .nav > .nav-item a:hover, .sidebar[data-background-color="white"] .nav > .nav-item a:focus {
          text-decoration: none; }
          .sidebar .nav > .nav-item a:hover p, .sidebar .nav > .nav-item a:focus p, .sidebar[data-background-color="white"] .nav > .nav-item a:hover p, .sidebar[data-background-color="white"] .nav > .nav-item a:focus p {
            color: #575962 !important;
            font-weight: 600; }
          .sidebar .nav > .nav-item a:hover i, .sidebar .nav > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav > .nav-item a:focus i {
            color: #4d7cfe !important; }
      .sidebar .nav > .nav-item a .letter-icon, .sidebar[data-background-color="white"] .nav > .nav-item a .letter-icon {
        color: #a1a2a6;
        margin-right: 15px;
        width: 25px;
        text-align: center;
        vertical-align: middle;
        float: left;
        font-size: 20px;
        font-weight: 200; }
      .sidebar .nav > .nav-item a i, .sidebar[data-background-color="white"] .nav > .nav-item a i {
        color: #8d9498;
        margin-right: 15px;
        width: 25px;
        text-align: center;
        vertical-align: middle;
        float: left;
        font-size: 18px;
        line-height: 30px; }
        .sidebar .nav > .nav-item a i[class^="flaticon-"], .sidebar[data-background-color="white"] .nav > .nav-item a i[class^="flaticon-"] {
          font-size: 20px; }
      .sidebar .nav > .nav-item a p, .sidebar[data-background-color="white"] .nav > .nav-item a p {
        font-size: 14px;
        margin-bottom: 0px;
        margin-right: 5px;
        white-space: nowrap;
        color: #8d9498; }
      .sidebar .nav > .nav-item a .caret, .sidebar[data-background-color="white"] .nav > .nav-item a .caret {
        margin-left: auto;
        margin-right: 10px;
        transition: all .5s;
        color: #8d9498; }
      .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true], .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] {
        background: transparent; }
        .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] p {
          color: #575962; }
        .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
          color: #4d7cfe; }
        .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] .caret, .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
          filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
          -webkit-transform: rotate(-180deg);
          transform: rotate(-180deg); }
        .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
          background: #1d7af3; }
    .sidebar .nav.nav-primary > .nav-item a:hover i, .sidebar .nav.nav-primary > .nav-item a:focus i, .sidebar .nav.nav-primary > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #1572E8 !important; }
    .sidebar .nav.nav-primary > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #1572E8 !important; }
    .sidebar .nav.nav-primary > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item.active a:before {
      background: #1572E8 !important; }
    .sidebar .nav.nav-primary > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item.active a i {
      color: #1572E8 !important; }
    .sidebar .nav.nav-secondary > .nav-item a:hover i, .sidebar .nav.nav-secondary > .nav-item a:focus i, .sidebar .nav.nav-secondary > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #6861CE !important; }
    .sidebar .nav.nav-secondary > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #6861CE !important; }
    .sidebar .nav.nav-secondary > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item.active a:before {
      background: #6861CE !important; }
    .sidebar .nav.nav-secondary > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-secondary > .nav-item.active a i {
      color: #6861CE !important; }
    .sidebar .nav.nav-info > .nav-item a:hover i, .sidebar .nav.nav-info > .nav-item a:focus i, .sidebar .nav.nav-info > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #48ABF7 !important; }
    .sidebar .nav.nav-info > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #48ABF7 !important; }
    .sidebar .nav.nav-info > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item.active a:before {
      background: #48ABF7 !important; }
    .sidebar .nav.nav-info > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-info > .nav-item.active a i {
      color: #48ABF7 !important; }
    .sidebar .nav.nav-success > .nav-item a:hover i, .sidebar .nav.nav-success > .nav-item a:focus i, .sidebar .nav.nav-success > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #31CE36 !important; }
    .sidebar .nav.nav-success > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #31CE36 !important; }
    .sidebar .nav.nav-success > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item.active a:before {
      background: #31CE36 !important; }
    .sidebar .nav.nav-success > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-success > .nav-item.active a i {
      color: #31CE36 !important; }
    .sidebar .nav.nav-warning > .nav-item a:hover i, .sidebar .nav.nav-warning > .nav-item a:focus i, .sidebar .nav.nav-warning > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #FFAD46 !important; }
    .sidebar .nav.nav-warning > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #FFAD46 !important; }
    .sidebar .nav.nav-warning > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item.active a:before {
      background: #FFAD46 !important; }
    .sidebar .nav.nav-warning > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-warning > .nav-item.active a i {
      color: #FFAD46 !important; }
    .sidebar .nav.nav-danger > .nav-item a:hover i, .sidebar .nav.nav-danger > .nav-item a:focus i, .sidebar .nav.nav-danger > .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item a:hover i, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item a:focus i, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #F25961 !important; }
    .sidebar .nav.nav-danger > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
      background: #F25961 !important; }
    .sidebar .nav.nav-danger > .nav-item.active a:before, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item.active a:before {
      background: #F25961 !important; }
    .sidebar .nav.nav-danger > .nav-item.active a i, .sidebar[data-background-color="white"] .nav.nav-danger > .nav-item.active a i {
      color: #F25961 !important; }
  .sidebar .nav-collapse, .sidebar[data-background-color="white"] .nav-collapse {
    margin-top: 0px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    padding-top: 10px; }
    .sidebar .nav-collapse li.active > a, .sidebar[data-background-color="white"] .nav-collapse li.active > a {
      font-weight: 600; }
    .sidebar .nav-collapse li a:before, .sidebar .nav-collapse li a:hover:before, .sidebar[data-background-color="white"] .nav-collapse li a:before, .sidebar[data-background-color="white"] .nav-collapse li a:hover:before {
      opacity: 0 !important; }
    .sidebar .nav-collapse li a, .sidebar[data-background-color="white"] .nav-collapse li a {
      margin-bottom: 3px !important;
      padding: 10px 25px !important; }
      .sidebar .nav-collapse li a .sub-item, .sidebar[data-background-color="white"] .nav-collapse li a .sub-item {
        font-size: 14px;
        position: relative;
        margin-left: 25px;
        opacity: .85; }
        .sidebar .nav-collapse li a .sub-item:before, .sidebar[data-background-color="white"] .nav-collapse li a .sub-item:before {
          content: '';
          height: 4px;
          width: 4px;
          background: rgba(131, 132, 138, 0.89);
          position: absolute;
          left: -15px;
          top: 50%;
          transform: translateY(-50%);
          border-radius: 100%; }
      .sidebar .nav-collapse li a:hover .sub-item, .sidebar[data-background-color="white"] .nav-collapse li a:hover .sub-item {
        opacity: 1; }
      .sidebar .nav-collapse li a .sidebar-mini-icon, .sidebar[data-background-color="white"] .nav-collapse li a .sidebar-mini-icon {
        font-size: 18px;
        color: #C3C5CA;
        margin-right: 15px;
        width: 25px;
        text-align: center;
        vertical-align: middle;
        float: left;
        font-weight: 300 !important; }
    .sidebar .nav-collapse.subnav, .sidebar[data-background-color="white"] .nav-collapse.subnav {
      padding-bottom: 10px;
      margin-bottom: 0px; }
      .sidebar .nav-collapse.subnav li a, .sidebar[data-background-color="white"] .nav-collapse.subnav li a {
        padding-left: 40px !important; }

/* Sidebar style 2 */
.sidebar.sidebar-style-2 .nav .nav-item {
  padding: 0 15px; }
  .sidebar.sidebar-style-2 .nav .nav-item a {
    padding: 8px 10px;
    border-radius: 5px; }
  .sidebar.sidebar-style-2 .nav .nav-item a:hover, .sidebar.sidebar-style-2 .nav .nav-item a:focus, .sidebar.sidebar-style-2 .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
    background: rgba(199, 199, 199, 0.2); }
    .sidebar.sidebar-style-2 .nav .nav-item a:hover p, .sidebar.sidebar-style-2 .nav .nav-item a:hover i, .sidebar.sidebar-style-2 .nav .nav-item a:focus p, .sidebar.sidebar-style-2 .nav .nav-item a:focus i, .sidebar.sidebar-style-2 .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar.sidebar-style-2 .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i {
      color: #575962 !important; }
  .sidebar.sidebar-style-2 .nav .nav-item.active a:before {
    background: transparent; }
  .sidebar.sidebar-style-2 .nav .nav-item .active a {
    background: rgba(199, 199, 199, 0.2); }
    .sidebar.sidebar-style-2 .nav .nav-item .active a p, .sidebar.sidebar-style-2 .nav .nav-item .active a i {
      color: #575962 !important; }
  .sidebar.sidebar-style-2 .nav .nav-item.submenu {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
    background: transparent !important; }
.sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a {
  background: #1572E8 !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(21, 114, 232, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a {
  background: #6861CE !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(104, 97, 206, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-secondary > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a {
  background: #48ABF7 !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(72, 171, 247, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-info > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a {
  background: #31CE36 !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(49, 206, 54, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-success > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a {
  background: #FFAD46 !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(255, 173, 70, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-warning > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a {
  background: #F25961 !important;
  box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1), 4px 4px 15px -5px rgba(242, 89, 97, 0.4); }
  .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a:before {
    background: transparent !important; }
  .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a p, .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a i, .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a .caret, .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a span {
    color: #ffffff !important; }
  .sidebar.sidebar-style-2 .nav.nav-danger > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i {
    color: #ffffff !important; }
.sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a:hover p, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a:hover i, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a:focus p, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a:focus i, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a:hover p, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a:hover i, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a:focus p, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a:focus i, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i {
  color: #b9babf !important; }
.sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a {
  color: #ffffff; }
  .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a p, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a i, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a .caret, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a span, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a p, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a i, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a .caret, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a span {
    color: #ffffff; }
  .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] p, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] i, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] .caret, .sidebar.sidebar-style-2[data-background-color="dark"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] span, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] p, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] i, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] .caret, .sidebar.sidebar-style-2[data-background-color="dark2"] .nav .nav-item.active a[data-toggle=collapse][aria-expanded=true] span {
    color: #ffffff; }

.quick-sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  right: -380px;
  width: 380px;
  overflow: auto;
  overflow-x: hidden;
  height: 100vh;
  display: block;
  z-index: 1;
  background: #ffffff;
  background-size: cover;
  background-position: center center;
  box-shadow: 2px 0px 20px rgba(69, 65, 78, 0.07);
  transition: all .3s;
  z-index: 1101;
  padding: 20px 20px 0; }
  .quick-sidebar .scroll-wrapper .scroll-element {
    opacity: 0.4 !important; }
  .quick-sidebar .scroll-wrapper:hover .scroll-element {
    opacity: .8 !important; }
  .quick-sidebar .close-quick-sidebar {
    position: absolute;
    right: 25px;
    color: #999; }
  .quick-sidebar .nav-link {
    padding-top: 0px !important;
    padding-left: 10px !important;
    padding-right: 10px !important;
    margin-right: 15px !important; }
  .quick-sidebar .quick-wrapper .quick-scroll {
    height: calc(100vh - 115px);
    overflow: auto;
    margin-bottom: 15px; }
  .quick-sidebar .quick-wrapper .quick-content {
    padding-bottom: 25px; }
  .quick-sidebar .quick-wrapper .category-title {
    font-size: 16px;
    font-weight: 600;
    padding-bottom: 10px;
    margin-top: 25px;
    display: block;
    border-bottom: 1px solid #f1f1f1;
    margin-bottom: 15px; }

.quick-sidebar-overlay {
  position: fixed;
  z-index: 1100;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.63); }

.main-panel {
  position: relative;
  width: calc(100% - 250px);
  height: 100vh;
  min-height: 100%;
  float: right;
  transition: all .3s; }
  .main-panel > .container {
    padding: 0px !important;
    min-height: calc(100% - 123px);
    margin-top: 61px;
    overflow: hidden;
    width: 100%;
    max-width: unset; }
  .main-panel > .container-full {
    padding: 0px !important;
    min-height: calc(100% - 123px);
    margin-top: 61px;
    overflow: hidden;
    width: 100%;
    max-width: unset; }
  .main-panel .page-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px; }
    .main-panel .page-header .page-title {
      margin-bottom: 0px; }
    .main-panel .page-header .btn-page-header-dropdown {
      width: 35px;
      height: 35px;
      font-size: 14px;
      padding: 0px;
      color: #6b6b6b;
      box-shadow: 0 2px 14px 0 rgba(144, 116, 212, 0.1) !important;
      border: 0; }
      .main-panel .page-header .btn-page-header-dropdown:after {
        display: none; }
    .main-panel .page-header .dropdown-menu {
      margin-top: 15px;
      top: 0px !important; }
      .main-panel .page-header .dropdown-menu:after {
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid #ffffff;
        position: absolute;
        top: -8px;
        right: 32px;
        content: ''; }
  .main-panel .page-divider {
    height: 0;
    margin: .3rem 0 1rem;
    overflow: hidden;
    border-top: 1px solid #ebecec; }

/*      Page Wrapper      */
.page-wrapper {
  min-height: calc(100vh - 57px);
  position: relative; }
  .page-wrapper.has-sidebar .page-inner {
    margin-right: 22.5rem; }

.page-navs {
  position: relative;
  display: block;
  padding-right: 1rem;
  padding-left: 1rem;
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.07);
  z-index: 1; }
  .page-navs .nav .nav-link {
    padding: 1rem !important; }
  .page-navs .nav-line {
    border: 0px !important; }
    .page-navs .nav-line .nav-link {
      border-bottom-width: 3px !important; }

.nav-scroller {
  overflow-x: auto; }
  .nav-scroller .nav {
    flex-wrap: nowrap;
    white-space: nowrap; }

@media (min-width: 992px) {
  .page-navs {
    padding-right: 2rem;
    padding-left: 2rem; } }
.page-inner {
  padding: 1.5rem 0; }

@media (min-width: 576px) {
  .page-inner {
    padding-right: 1rem;
    padding-left: 1rem; } }
@media (min-width: 992px) {
  .page-inner {
    padding-right: 2rem;
    padding-left: 2rem; } }
.page-inner-fill {
  padding: 0;
  height: calc(100% - 57px);
  display: flex;
  flex-direction: column; }

.page-sidebar {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  display: flex;
  flex-direction: column;
  max-width: 22.5rem;
  box-shadow: none;
  transform: translate3d(100%, 0, 0);
  overflow: auto;
  z-index: 999;
  transition: transform .2s ease-in-out;
  border-left: 1px solid rgba(61, 70, 79, 0.125) !important; }
  .page-sidebar .back {
    width: 100%;
    display: flex;
    align-items: center;
    padding: 1rem;
    box-shadow: 0 0 0 1px rgba(61, 70, 79, 0.05), 0 1px 3px 0 rgba(61, 70, 79, 0.15);
    font-size: 15px; }

.page-sidebar-section {
  flex: 1;
  overflow-y: auto; }

@media (min-width: 1200px) {
  .page-sidebar {
    transform: translateZ(0); } }
@media (max-width: 1200px) {
  .page-wrapper.has-sidebar .page-inner {
    margin-right: 0px; }

  .pagesidebar_open .page-sidebar {
    transform: translate3d(0, 0, 0) !important;
    max-width: unset; } }
.page-with-aside {
  display: flex; }
  .page-with-aside .page-aside {
    width: 280px;
    min-height: 100vh;
    border-right: 1px solid #f1f1f1;
    padding: 15px 0; }
    .page-with-aside .page-aside .aside-header {
      padding: 15px 22px; }
      .page-with-aside .page-aside .aside-header .title {
        font-size: 24px; }
      .page-with-aside .page-aside .aside-header .description {
        font-size: 12px; }
    .page-with-aside .page-aside .aside-nav .nav {
      flex-direction: column; }
      .page-with-aside .page-aside .aside-nav .nav > li {
        padding: 8px 22px;
        margin-bottom: 5px; }
        .page-with-aside .page-aside .aside-nav .nav > li:hover, .page-with-aside .page-aside .aside-nav .nav > li:focus, .page-with-aside .page-aside .aside-nav .nav > li.active {
          background: rgba(51, 51, 51, 0.08); }
        .page-with-aside .page-aside .aside-nav .nav > li.active {
          padding: 12px 22px;
          font-weight: 600; }
          .page-with-aside .page-aside .aside-nav .nav > li.active > a {
            color: #575962 !important; }
        .page-with-aside .page-aside .aside-nav .nav > li > a {
          color: #83848a;
          display: flex;
          align-items: center;
          font-size: 12px; }
          .page-with-aside .page-aside .aside-nav .nav > li > a:hover, .page-with-aside .page-aside .aside-nav .nav > li > a:focus {
            text-decoration: none; }
          .page-with-aside .page-aside .aside-nav .nav > li > a i {
            font-size: 20px;
            margin-right: 15px;
            color: #a1a2a6; }
    .page-with-aside .page-aside .aside-nav .label {
      padding: 5px 22px;
      margin-top: 22px;
      margin-bottom: 5px;
      display: block; }
    .page-with-aside .page-aside .aside-compose {
      padding: 25px 22px; }
  .page-with-aside .page-content {
    width: calc(100% - 280px); }

.footer {
  border-top: 1px solid #eee;
  padding: 15px;
  background: #ffffff;
  position: absolute;
  width: 100%; }
  .footer .container, .footer .container-fluid {
    display: flex;
    align-items: center; }

/*    sidebar minimized   */
@media screen and (min-width: 991px) {
  .sidebar_minimize .main-panel {
    width: calc(100% - 75px);
    transition: all .3s; }
  .sidebar_minimize .logo-header {
    width: 75px;
    transition: all .3s;
    padding: 0px;
    text-align: center; }
    .sidebar_minimize .logo-header .big-logo {
      margin-right: 0px; }
    .sidebar_minimize .logo-header .logo {
      position: absolute;
      transform: translate3d(25px, 0, 0);
      opacity: 0; }
      .sidebar_minimize .logo-header .logo img {
        display: none; }
  .sidebar_minimize .logo-header .nav-toggle {
    position: absolute;
    left: 50% !important;
    transform: translateX(-50%);
    height: 100%;
    right: 0 !important; }
  .sidebar_minimize .sidebar {
    width: 75px;
    transition: all .3s; }
    .sidebar_minimize .sidebar .sidebar-wrapper {
      width: 75px;
      transition: all .3s; }
      .sidebar_minimize .sidebar .sidebar-wrapper .user {
        padding-left: 0px;
        padding-right: 0px; }
        .sidebar_minimize .sidebar .sidebar-wrapper .user [class^="avatar-"] {
          float: none !important;
          margin: auto; }
        .sidebar_minimize .sidebar .sidebar-wrapper .user .info {
          display: none; }
          .sidebar_minimize .sidebar .sidebar-wrapper .user .info span {
            display: none; }
      .sidebar_minimize .sidebar .sidebar-wrapper .nav-item {
        position: relative; }
        .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a .letter-icon {
          display: block !important; }
        .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a i {
          margin-right: unset; }
        .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a .badge, .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a span, .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a .caret, .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a p {
          display: none;
          transition: all .3s; }
        .sidebar_minimize .sidebar .sidebar-wrapper .nav-item a .sidebar-mini-icon {
          display: block !important;
          margin-right: 0px; }
        .sidebar_minimize .sidebar .sidebar-wrapper .nav-item.submenu .nav-collapse, .sidebar_minimize .sidebar .sidebar-wrapper .nav-item.active .nav-collapse {
          display: none; }
      .sidebar_minimize .sidebar .sidebar-wrapper .nav-section .text-section {
        display: none; }
      .sidebar_minimize .sidebar .sidebar-wrapper .nav-section .sidebar-mini-icon {
        display: block; }
  .sidebar_minimize .sidebar:hover {
    width: 250px; }
    .sidebar_minimize .sidebar:hover .sidebar-wrapper {
      width: 250px; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .user {
        padding-left: 15px;
        padding-right: 15px; }
        .sidebar_minimize .sidebar:hover .sidebar-wrapper .user [class^="avatar-"] {
          float: left !important;
          margin-right: 11px !important; }
        .sidebar_minimize .sidebar:hover .sidebar-wrapper .user .info {
          display: block; }
          .sidebar_minimize .sidebar:hover .sidebar-wrapper .user .info span {
            display: block; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a i {
        margin-right: 15px; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a .badge, .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a span, .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a .caret, .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a p {
        display: block; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item a .sidebar-mini-icon {
        display: block !important;
        margin-right: 15px; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item.submenu .nav-collapse, .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-item.active .nav-collapse {
        display: block; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-section .sidebar-mini-icon {
        display: none; }
      .sidebar_minimize .sidebar:hover .sidebar-wrapper .nav-section .text-section {
        display: block; }
  .sidebar_minimize.sidebar_minimize_hover .logo-header {
    width: 250px;
    padding-left: 25px;
    padding-right: 25px;
    text-align: left; }
    .sidebar_minimize.sidebar_minimize_hover .logo-header .logo {
      opacity: 1 !important;
      transform: translate3d(0, 0, 0) !important;
      position: relative !important; }
      .sidebar_minimize.sidebar_minimize_hover .logo-header .logo img {
        display: inline-block !important; }
  .sidebar_minimize.sidebar_minimize_hover .main-panel {
    width: calc(100% - 250px); }

  .sidebar_minimize_hover .logo-header .nav-toggle {
    right: 18px !important;
    transform: translateX(0%) !important;
    left: unset !important; } }
.quick_sidebar_open .quick-sidebar {
  right: 0px !important; }
.quick_sidebar_open .rtl .quick-sidebar {
  left: 0px !important;
  right: unset !important; }

/* Fullheight side */
.fullheight-side .logo-header {
  -webkit-box-shadow: 4px 0px 10px rgba(69, 65, 78, 0.06);
  -moz-box-shadow: 4px 0px 10px rgba(69, 65, 78, 0.06);
  box-shadow: 4px 0px 10px rgba(69, 65, 78, 0.06); }
.fullheight-side .sidebar {
  z-index: 1002; }
.fullheight-side .navbar-header {
  min-height: 62px;
  transition: all .3s; }
.fullheight-side .main-panel {
  min-height: calc(100vh - 62px);
  height: unset; }
  .fullheight-side .main-panel > .container, .fullheight-side .main-panel > .container-full {
    min-height: calc(100vh - 129px); }

@media screen and (min-width: 991px) {
  .fullheight-side .navbar-header {
    width: calc(100% - 250px);
    float: right; }
  .fullheight-side.sidebar_minimize .navbar-header {
    width: calc(100% - 75px) !important; }
  .fullheight-side.sidebar_minimize_hover .navbar-header {
    width: calc(100% - 250px) !important;
    float: right; } }
@media screen and (max-width: 991px) {
  .fullheight-side .logo-header {
    z-index: 1002;
    transition: all .5s; }
  .fullheight-side .navbar-header {
    z-index: 1001; }
    .fullheight-side .navbar-header.navbar-header-transparent {
      background: #fff;
      position: fixed; }

  .nav_open .fullheight-side .logo-header {
    -webkit-transform: translate3d(250px, 0, 0);
    -moz-transform: translate3d(250px, 0, 0);
    -o-transform: translate3d(250px, 0, 0);
    -ms-transform: translate3d(250px, 0, 0);
    transform: translate3d(250px, 0, 0) !important; }
  .nav_open.topbar_open .fullheight-side .navbar-header {
    -webkit-transform: translate3d(250px, 61px, 0);
    -moz-transform: translate3d(250px, 61px, 0);
    -o-transform: translate3d(250px, 61px, 0);
    -ms-transform: translate3d(250px, 61px, 0);
    transform: translate3d(250px, 61px, 0) !important; } }
/* No Box-Shadow Style */
.no-box-shadow-style * {
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important; }
.no-box-shadow-style .card, .no-box-shadow-style .row-card-no-pd {
  border: 1px solid #eaeaea; }

/*    overlay sidebar    */
.overlay-sidebar:not(.is-show) .sidebar {
  left: -250px; }
.overlay-sidebar .main-panel {
  width: 100% !important; }

/*    compact wrapper    */
@media screen and (min-width: 991px) {
  .compact-wrapper .main-header .logo-header {
    width: 175px; }
  .compact-wrapper .sidebar {
    width: 175px; }
    .compact-wrapper .sidebar .badge {
      position: absolute;
      top: 8px;
      right: 8px; }
    .compact-wrapper .sidebar .text-section {
      text-align: center; }
    .compact-wrapper .sidebar .nav > .nav-item a {
      flex-direction: column; }
      .compact-wrapper .sidebar .nav > .nav-item a i {
        margin-right: 0px; }
      .compact-wrapper .sidebar .nav > .nav-item a p {
        margin-right: 0px; }
      .compact-wrapper .sidebar .nav > .nav-item a .caret {
        display: none; }
    .compact-wrapper .sidebar .nav-collapse li a .sub-item {
      margin-left: 0px;
      text-align: center; }
      .compact-wrapper .sidebar .nav-collapse li a .sub-item:before {
        display: none; }
  .compact-wrapper .main-panel {
    width: calc(100% - 175px); } }
/*    classic     */
@media screen and (min-width: 991px) {
  .classic-wrapper .classic-grid {
    margin: 93px 40px 30px; }
  .classic-wrapper .main-header {
    top: 0; }
    .classic-wrapper .main-header .logo-header {
      padding: 0 40px;
      width: 290px; }
  .classic-wrapper .sidebar {
    position: relative;
    float: left;
    margin-top: 0px; }
    .classic-wrapper .sidebar .sidebar-wrapper {
      max-height: unset;
      min-height: 100%; }
  .classic-wrapper .navbar-header {
    padding-right: 30px; }
  .classic-wrapper .main-panel {
    height: unset; }
    .classic-wrapper .main-panel .container, .classic-wrapper .main-panel .container-full {
      margin-top: 0px; }
  .classic-wrapper .page-inner {
    padding-right: 0px;
    padding-top: 5px; }
  .classic-wrapper .board {
    height: 100%; }

  .sidebar_minimize .classic-wrapper .logo-header .logo {
    position: relative;
    transform: unset;
    opacity: 1; }
    .sidebar_minimize .classic-wrapper .logo-header .logo img {
      display: inline-block; }
  .sidebar_minimize .classic-wrapper .logo-header .nav-toggle {
    left: unset;
    transform: unset;
    right: 18px !important; } }
.classic-wrapper {
  height: unset; }
  .classic-wrapper .main-panel {
    height: unset; }
  .classic-wrapper .footer {
    position: unset; }

.classic-grid {
  min-height: 100vh;
  height: 100%;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap; }

/*    Static Sidebar    */
@media screen and (min-width: 991px) {
  .static-sidebar {
    height: unset; }
    .static-sidebar .sidebar {
      position: static;
      float: left; }
      .static-sidebar .sidebar .sidebar-wrapper {
        max-height: unset;
        min-height: 100%; }
    .static-sidebar .main-panel {
      height: unset; }
      .static-sidebar .main-panel .container {
        margin-bottom: 60px; }
    .static-sidebar .footer {
      position: absolute;
      bottom: 0; } }
/*      Mail      */
.mail-wrapper .toggle-email-nav {
  margin-top: 10px;
  display: none; }
.mail-wrapper .mail-content .inbox-head, .mail-wrapper .mail-content .email-head {
  padding: 35px 25px 20px; }
  .mail-wrapper .mail-content .inbox-head h3, .mail-wrapper .mail-content .email-head h3 {
    font-size: 22px;
    font-weight: 300;
    margin: 0px; }
.mail-wrapper .mail-content .email-head {
  padding: 35px 25px;
  border-bottom: 1px solid #f1f1f1; }
  .mail-wrapper .mail-content .email-head .favorite {
    color: #eee;
    margin-right: 5px; }
    .mail-wrapper .mail-content .email-head .favorite.active {
      color: #FFC600; }
  .mail-wrapper .mail-content .email-head .controls {
    margin-left: auto; }
    .mail-wrapper .mail-content .email-head .controls > a {
      color: #9c9c9c;
      font-size: 18px;
      padding: 0 5px; }
      .mail-wrapper .mail-content .email-head .controls > a:hover {
        text-decoration: none;
        opacity: 0.8; }
      .mail-wrapper .mail-content .email-head .controls > a:last-child {
        padding-right: 0px; }
.mail-wrapper .mail-content .email-sender {
  padding: 14px 25px;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #f1f1f1; }
  .mail-wrapper .mail-content .email-sender .avatar {
    padding-right: 12px; }
    .mail-wrapper .mail-content .email-sender .avatar img {
      max-width: 40px;
      max-height: 40px;
      border-radius: 50%; }
  .mail-wrapper .mail-content .email-sender .date {
    margin-left: auto; }
  .mail-wrapper .mail-content .email-sender .sender .action {
    display: inline-block; }
    .mail-wrapper .mail-content .email-sender .sender .action > a {
      cursor: pointer; }
.mail-wrapper .mail-content .email-body {
  padding: 30px 28px; }
.mail-wrapper .mail-content .email-attachments {
  padding: 25px 28px;
  border-top: 1px solid #f1f1f1; }
  .mail-wrapper .mail-content .email-attachments .title {
    font-weight: 400;
    margin-bottom: 10px; }
    .mail-wrapper .mail-content .email-attachments .title span {
      font-weight: 400; }
  .mail-wrapper .mail-content .email-attachments ul {
    padding-left: 0px;
    list-style: none; }
    .mail-wrapper .mail-content .email-attachments ul li {
      padding: 6px 0; }
      .mail-wrapper .mail-content .email-attachments ul li a {
        font-weight: 400; }
        .mail-wrapper .mail-content .email-attachments ul li a:hover {
          text-decoration: none; }
        .mail-wrapper .mail-content .email-attachments ul li a i {
          font-size: 20px;
          display: inline-block;
          vertical-align: middle; }
        .mail-wrapper .mail-content .email-attachments ul li a span {
          font-weight: 400; }
.mail-wrapper .mail-content .inbox-body {
  padding: 20px 0px; }
  .mail-wrapper .mail-content .inbox-body .mail-option {
    padding: 0 20px;
    margin-bottom: 20px;
    display: flex; }
    .mail-wrapper .mail-content .inbox-body .mail-option .chk-all {
      display: inline-block; }
    .mail-wrapper .mail-content .inbox-body .mail-option .btn-option {
      color: #555 !important;
      border: 1px solid #ebedf2 !important;
      font-weight: 600;
      background: #ffffff !important;
      box-shadow: 2px 2px 3px 0px #f2f1f1 !important; }
    .mail-wrapper .mail-content .inbox-body .mail-option .form-check {
      padding: 0; }
      .mail-wrapper .mail-content .inbox-body .mail-option .form-check .form-check-sign:before {
        border: 1px solid #eee;
        background: #eeeeee; }
  .mail-wrapper .mail-content .inbox-body .email-list .email-list-item {
    padding: 14px 20px;
    display: table;
    cursor: pointer;
    position: relative;
    font-size: 12px;
    width: 100%;
    border-top: 1px solid #f1f1f1; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item:hover {
      background: #f6f5f5; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions, .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail {
      vertical-align: top;
      display: table-cell; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions {
      width: 50px; }
      .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .custom-checkbox {
        margin-right: 0px; }
      .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .favorite {
        color: #eee;
        font-size: 18px; }
        .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .favorite:hover {
          text-decoration: none;
          color: #969696; }
        .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .favorite.active, .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .favorite.active:hover {
          color: #FFC600; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail p, .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .msg {
      font-size: 12px; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .msg {
      margin-bottom: 0px;
      margin-top: 8px; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .from {
      font-size: 13px; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .date {
      font-size: 12px;
      display: flex;
      align-items: center; }
      .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .date .paperclip {
        font-size: 16px;
        padding-right: 4px; }
    .mail-wrapper .mail-content .inbox-body .email-list .email-list-item.unread {
      font-weight: 400;
      background: #fbfbfb; }
      .mail-wrapper .mail-content .inbox-body .email-list .email-list-item.unread:after {
        content: '';
        display: block;
        position: absolute;
        width: 3px;
        background: #1572E8;
        top: -1px;
        left: 0px;
        bottom: -1px;
        height: calc(100% + 2px); }
      .mail-wrapper .mail-content .inbox-body .email-list .email-list-item.unread .email-list-detail .from {
        font-weight: 600; }
.mail-wrapper .mail-content .email-compose-fields, .mail-wrapper .mail-content .email-editor {
  padding: 20px 25px; }
.mail-wrapper .mail-content .email-compose-fields {
  padding: 20px 25px;
  border-bottom: 1px solid #f1f1f1; }
.mail-wrapper .mail-content .email-action {
  text-align: right;
  margin-bottom: 15px; }
  .mail-wrapper .mail-content .email-action > .btn {
    margin-right: 7px; }
    .mail-wrapper .mail-content .email-action > .btn:last-child {
      margin-right: 0px; }

/*    Flex-1    */
.flex-1 {
  -ms-flex: 1;
  flex: 1; }

/*    Metric    */
.metric {
  display: flex;
  padding: 1rem;
  flex-direction: column; }

/* RTL Layout */
.rtl {
  direction: rtl;
  text-align: right;
  position: unset; }
  .rtl .logo-header {
    float: right; }
    .rtl .logo-header .nav-toggle {
      left: 18px;
      right: unset; }
  .rtl .nav, .rtl .list-unstyled {
    padding-right: 0px; }
  .rtl .navbar .navbar-nav .nav-item {
    margin-left: 7px; }
    .rtl .navbar .navbar-nav .nav-item:last-child {
      margin-left: 0px; }
  .rtl .navbar-expand-lg .navbar-nav .dropdown-menu {
    left: 0;
    right: auto; }
  .rtl .navbar-header .dropdown-menu:after {
    left: 10px;
    right: unset; }
  .rtl .sidebar {
    right: 0;
    left: unset; }
    .rtl .sidebar .user .info a > span {
      text-align: right; }
    .rtl .sidebar .user .info .caret {
      left: 0px;
      right: unset; }
    .rtl .sidebar .nav > .nav-item a i {
      margin-right: 0px;
      margin-left: 15px; }
    .rtl .sidebar .nav > .nav-item a p {
      margin-right: 0px; }
    .rtl .sidebar .nav > .nav-item a .caret {
      margin-right: auto;
      margin-left: 10px; }
    .rtl .sidebar .nav .nav-section .text-section {
      text-align: right; }
    .rtl .sidebar .nav-collapse li a .sub-item {
      margin-left: 0px;
      margin-right: 25px; }
      .rtl .sidebar .nav-collapse li a .sub-item:before {
        left: unset;
        right: -15px; }
    .rtl .sidebar .nav-collapse.subnav li a {
      padding-left: 25px !important;
      padding-right: 40px !important; }
  .rtl .sidebar .nav > .nav-item.active > a:before, .rtl .sidebar[data-background-color="white"] .nav > .nav-item.active > a:before, .rtl .sidebar .nav > .nav-item.active:hover > a:before, .rtl .sidebar[data-background-color="white"] .nav > .nav-item.active:hover > a:before, .rtl .sidebar .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before, .rtl .sidebar[data-background-color="white"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true]:before {
    left: unset;
    right: 0; }
  .rtl .quick-sidebar {
    left: -380px;
    right: unset; }
    .rtl .quick-sidebar .nav-link {
      margin-left: 15px !important;
      margin-right: unset; }
    .rtl .quick-sidebar .close-quick-sidebar {
      right: unset;
      left: 25px; }
  .rtl .scrollbar-inner > .scroll-element.scroll-y, .rtl .scrollbar-outer > .scroll-element.scroll-y {
    left: 2px;
    right: unset; }
  .rtl .scrollbar-outer > .scroll-content.scroll-scrolly_visible {
    right: -12px;
    margin-right: 12px !important; }
  .rtl .messages-contact .contact-list .user a .user-data, .rtl .messages-contact .contact-list .user a .user-data2 {
    margin-right: 20px;
    margin-left: 0; }
  .rtl .messages-wrapper .messages-body .message-in, .rtl .conversations-body .message-in {
    margin-left: 40px;
    margin-right: 0;
    float: right; }
  .rtl .messages-wrapper .messages-body .message-in .message-body .message-content, .rtl .conversations-body .message-in .message-body .message-content {
    margin-left: 0;
    margin-right: 10px; }
    .rtl .messages-wrapper .messages-body .message-in .message-body .message-content:before, .rtl .conversations-body .message-in .message-body .message-content:before {
      left: unset;
      right: -10px;
      border-left: 10px solid #f7f7f7;
      border-right-width: 0; }
  .rtl .messages-wrapper .messages-body .message-in .message-body .date, .rtl .conversations-body .message-in .message-body .date {
    margin-right: 10px;
    padding-right: 12px;
    margin-left: 0;
    padding-left: 0; }
  .rtl .messages-wrapper .messages-body .message-out, .rtl .conversations-body .message-out {
    float: left;
    margin-left: 0;
    margin-right: 40px; }
  .rtl .messages-wrapper .messages-body .message-out .message-body .message-content, .rtl .conversations-body .message-out .message-body .message-content {
    margin-right: 0;
    margin-left: 10px; }
    .rtl .messages-wrapper .messages-body .message-out .message-body .message-content:before, .rtl .conversations-body .message-out .message-body .message-content:before {
      right: unset;
      left: -10px;
      border-right: 10px solid #1572E8;
      border-left-width: 0; }
  .rtl .messages-wrapper .messages-body .message-out .message-body .date, .rtl .conversations-body .message-out .message-body .date {
    margin-left: 10px;
    padding-left: 15px;
    margin-right: 0;
    padding-right: 0;
    text-align: left; }
  .rtl .messages-form .messages-form-control {
    padding-right: 0;
    padding-left: 15px; }
  .rtl .main-panel {
    float: left; }
  .rtl .card-title, .rtl .card-category {
    text-align: right; }
  .rtl .card .card-header .card-head-row .card-tools {
    margin-right: auto;
    margin-left: unset;
    padding-left: 0;
    padding-right: 15px; }
  .rtl .card-stats .col-icon {
    margin-left: 0px;
    margin-right: 15px; }
  .rtl .card-pricing .specification-list {
    padding-right: 0px; }
  .rtl .card-profile .user-stats [class^="col"] {
    border-left: 1px solid #ebebeb;
    border-right-width: 0; }
    .rtl .card-profile .user-stats [class^="col"]:last-child {
      border-left: 0px; }
  .rtl .btn .btn-label i {
    margin-left: 2px;
    margin-right: -2px; }
  .rtl .dropdown-toggle::after {
    margin-right: .255em;
    margin-left: 0; }
  .rtl .avatar-online::before, .rtl .avatar-offline::before, .rtl .avatar-away::before {
    left: 0;
    right: unset; }
  .rtl .badge {
    margin-left: unset;
    margin-right: auto; }
  .rtl .nav-pills.nav-pills-no-bd li {
    margin-left: unset !important;
    margin-right: 15px; }
  .rtl .nav-pills.nav-pills-no-bd li:first-child {
    margin-right: 0; }
  .rtl .input-group > .custom-select:first-child, .rtl .input-group > .form-control:first-child {
    border-radius: 0 .25rem .25rem 0 !important; }
  .rtl .input-group > .input-group-append > .btn, .rtl .input-group > .input-group-append > .input-group-text, .rtl .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .rtl .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .rtl .input-group > .input-group-prepend:not(:first-child) > .btn, .rtl .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
    border-radius: .25rem 0 0 .25rem !important; }
  .rtl .btn-group > .btn-group:first-child > .btn, .rtl .btn-group > .btn:first-child:not(.dropdown-toggle) {
    border-radius: 0 3px 3px 0 !important; }
  .rtl .btn-group > .btn-group:last-child > .btn, .rtl .btn-group > .btn:last-child {
    border-radius: 3px 0 0 3px !important; }
  .rtl .btn-group .btn + .btn, .rtl .btn-group .btn + .btn-group, .rtl .btn-group .btn-group + .btn, .rtl .btn-group .btn-group + .btn-group, .rtl .btn-group-vertical .btn + .btn, .rtl .btn-group-vertical .btn + .btn-group, .rtl .btn-group-vertical .btn-group + .btn, .rtl .btn-group-vertical .btn-group + .btn-group {
    margin-right: -1px;
    margin-left: unset; }
  .rtl .activity-feed .feed-item {
    border-left-width: 0;
    border-right: 2px solid #e4e8eb;
    padding-right: 30px;
    padding-left: 0; }
    .rtl .activity-feed .feed-item:after {
      left: unset;
      right: -7px; }
  .rtl .dropdown-menu {
    text-align: right; }
  .rtl .pagination {
    padding-right: 0; }
  .rtl .notif-box .notif-center a .notif-content, .rtl .messages-notif-box .notif-center a .notif-content {
    padding: 10px 0px 10px 15px; }
  .rtl .avatar-group .avatar + .avatar {
    margin-left: unset;
    margin-right: -.75rem; }
  .rtl .html-legend li span {
    margin-right: 0;
    margin-left: 10px; }
  .rtl .custom-control.custom-radio, .rtl .custom-control.custom-checkbox {
    padding-left: 0;
    padding-right: 2em; }
  .rtl .custom-control-label::before, .rtl .custom-control-label::after {
    left: 0;
    right: -1.5rem; }
  .rtl .toggle-off.btn {
    padding-left: 42px; }
  .rtl .tasks-wrapper .tasks-content .tasks-list li .custom-control.custom-checkbox {
    margin-left: 50px !important;
    margin-right: 0 !important; }
  .rtl .tasks-wrapper .tasks-content .tasks-list li .task-action {
    right: unset;
    left: 0; }
  .rtl .settings-wrapper .settings-content .settings-list {
    padding-right: 0; }
  .rtl .settings-wrapper .settings-content .settings-list li .item-control {
    float: left; }
  .rtl .page-with-aside .page-aside .aside-nav .nav > li > a i {
    margin-left: 15px;
    margin-right: 0; }
  .rtl .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-detail .date .paperclip {
    padding-right: 0;
    padding-left: 4px; }
  .rtl .mail-wrapper .mail-content .inbox-body .email-list .email-list-item .email-list-actions .custom-checkbox {
    margin-left: 0;
    margin-right: 25px; }
  .rtl .mail-wrapper .mail-content .email-sender .avatar {
    padding-right: 0;
    padding-left: 12px; }
  .rtl .mail-wrapper .mail-content .email-head .controls > a:last-child {
    padding-right: 5px;
    padding-left: 0; }
  .rtl .mail-wrapper .mail-content .email-attachments ul {
    padding-right: 0; }

/*     	Customable Layouts Colors     */
.main-header .navbar-header[data-background-color] .nav-search .input-group, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group {
  border: 0;
  background: rgba(0, 0, 0, 0.14) !important;
  box-shadow: 3px 3px 6px 0 rgba(0, 0, 0, 0.07);
  transition: all .4s; }
  .main-header .navbar-header[data-background-color] .nav-search .input-group .form-control, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .form-control {
    color: #ffffff !important; }
    .main-header .navbar-header[data-background-color] .nav-search .input-group .form-control::-webkit-input-placeholder, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .form-control::-webkit-input-placeholder {
      /* Chrome/Opera/Safari */
      opacity: 1; }
    .main-header .navbar-header[data-background-color] .nav-search .input-group .form-control::-moz-placeholder, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .form-control::-moz-placeholder {
      /* Firefox 19+ */
      opacity: 1; }
    .main-header .navbar-header[data-background-color] .nav-search .input-group .form-control:-ms-input-placeholder, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .form-control:-ms-input-placeholder {
      /* IE 10+ */
      opacity: 1; }
    .main-header .navbar-header[data-background-color] .nav-search .input-group .form-control:-moz-placeholder, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .form-control:-moz-placeholder {
      /* Firefox 18- */
      opacity: 1; }
  .main-header .navbar-header[data-background-color] .nav-search .input-group .search-icon, .main-header[data-background-color="custom"] .navbar-header .nav-search .input-group .search-icon {
    color: #ffffff !important; }
.main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group {
  background: #fff !important; }
  .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .form-control, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .form-control {
    color: inherit !important; }
    .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .form-control::-webkit-input-placeholder, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .form-control::-webkit-input-placeholder {
      /* Chrome/Opera/Safari */
      color: #bfbfbf !important; }
    .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .form-control::-moz-placeholder, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .form-control::-moz-placeholder {
      /* Firefox 19+ */
      color: #bfbfbf !important; }
    .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .form-control:-ms-input-placeholder, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .form-control:-ms-input-placeholder {
      /* IE 10+ */
      color: #bfbfbf !important; }
    .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .form-control:-moz-placeholder, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .form-control:-moz-placeholder {
      /* Firefox 18- */
      color: #bfbfbf !important; }
  .main-header .navbar-header[data-background-color] #search-nav.focus .nav-search .input-group .search-icon, .main-header[data-background-color="custom"] .navbar-header #search-nav.focus .nav-search .input-group .search-icon {
    color: #bfbfbf !important; }
.main-header .navbar-header[data-background-color] .navbar-nav .nav-item .nav-link, .main-header[data-background-color="custom"] .navbar-header .navbar-nav .nav-item .nav-link {
  color: #ffffff !important; }
  .main-header .navbar-header[data-background-color] .navbar-nav .nav-item .nav-link:hover, .main-header[data-background-color="custom"] .navbar-header .navbar-nav .nav-item .nav-link:hover, .main-header .navbar-header[data-background-color] .navbar-nav .nav-item .nav-link:focus, .main-header[data-background-color="custom"] .navbar-header .navbar-nav .nav-item .nav-link:focus {
    background: rgba(31, 30, 30, 0.12); }
.main-header .navbar-header[data-background-color] .navbar-nav .nav-item.active .nav-link, .main-header[data-background-color="custom"] .navbar-header .navbar-nav .nav-item.active .nav-link {
  background: rgba(31, 30, 30, 0.12); }

.main-header .navbar-header[data-background-color="dark"] .nav-search .input-group, .main-header .navbar-header[data-background-color="dark2"] .nav-search .input-group {
  background: rgba(185, 185, 185, 0.18) !important; }
.main-header .navbar-header[data-background-color="dark"] .navbar-nav .nav-item .nav-link:hover, .main-header .navbar-header[data-background-color="dark"] .navbar-nav .nav-item .nav-link:focus, .main-header .navbar-header[data-background-color="dark2"] .navbar-nav .nav-item .nav-link:hover, .main-header .navbar-header[data-background-color="dark2"] .navbar-nav .nav-item .nav-link:focus {
  background: rgba(185, 185, 185, 0.18) !important; }
.main-header .navbar-header[data-background-color="dark"] .navbar-nav .nav-item.active .nav-link, .main-header .navbar-header[data-background-color="dark2"] .navbar-nav .nav-item.active .nav-link {
  background: rgba(185, 185, 185, 0.18) !important; }
.main-header .navbar-header[data-background-color="white"] .nav-search .input-group, .main-header .navbar-header .navbar-header-transparent .nav-search .input-group {
  background: #eee; }
  .main-header .navbar-header[data-background-color="white"] .nav-search .input-group .form-control, .main-header .navbar-header .navbar-header-transparent .nav-search .input-group .form-control {
    color: #8d9498 !important; }
  .main-header .navbar-header[data-background-color="white"] .nav-search .input-group .search-icon, .main-header .navbar-header .navbar-header-transparent .nav-search .input-group .search-icon {
    color: #8d9498 !important; }
.main-header .navbar-header[data-background-color="white"] .navbar-nav .nav-item .nav-link, .main-header .navbar-header .navbar-header-transparent .navbar-nav .nav-item .nav-link {
  color: #8d9498 !important; }
  .main-header .navbar-header[data-background-color="white"] .navbar-nav .nav-item .nav-link:hover, .main-header .navbar-header[data-background-color="white"] .navbar-nav .nav-item .nav-link:focus, .main-header .navbar-header .navbar-header-transparent .navbar-nav .nav-item .nav-link:hover, .main-header .navbar-header .navbar-header-transparent .navbar-nav .nav-item .nav-link:focus {
    background: #eee !important; }
.main-header .navbar-header[data-background-color="white"] .navbar-nav .nav-item.active .nav-link, .main-header .navbar-header .navbar-header-transparent .navbar-nav .nav-item.active .nav-link {
  background: #eee !important; }

.btn-toggle {
  color: #fff !important; }

.logo-header[data-background-color] .navbar-toggler .navbar-toggler-icon {
  color: #ffffff !important; }
.logo-header[data-background-color] .more {
  color: #ffffff !important; }
.logo-header[data-background-color="white"] .navbar-toggler .navbar-toggler-icon, .logo-header[data-background-color="white"] .more, .logo-header[data-background-color="white"] .btn-toggle, .logo-header[data-background-color="grey"] .navbar-toggler .navbar-toggler-icon, .logo-header[data-background-color="grey"] .more, .logo-header[data-background-color="grey"] .btn-toggle {
  color: #8d9498 !important; }

.logo-header[data-background-color="grey"], .sidebar[data-background-color="grey"] {
  -webkit-box-shadow: none !important;
  -moz-box-shadow: none !important;
  box-shadow: none !important; }

.logo-header[data-background-color="white"] {
  background: #ffffff !important; }

.navbar-header[data-background-color="white"] {
  background: #ffffff !important; }

.logo-header[data-background-color="grey"] {
  background: #fafafe !important; }

.logo-header[data-background-color="dark"] {
  background: #1a2035 !important; }

.logo-header[data-background-color="dark2"] {
  background: #1f283e !important; }

.navbar-header[data-background-color="dark"] {
  background: #1a2035 !important; }

.navbar-header[data-background-color="dark2"] {
  background: #1f283e !important; }

.logo-header[data-background-color="blue"] {
  background: #1572E8 !important; }

.logo-header[data-background-color="blue2"] {
  background: #1269DB !important; }

.navbar-header[data-background-color="blue"] {
  background: #1572E8 !important; }

.navbar-header[data-background-color="blue2"] 
{
  background: #1269DB !important; 
}

.logo-header[data-background-color="purple"] {
  background: #6861CE !important; }

.logo-header[data-background-color="purple2"] {
  background: #5C55BF !important; }

.navbar-header[data-background-color="purple"] {
  background: #6861CE !important; }

.navbar-header[data-background-color="purple2"] {
  background: #5C55BF !important; }

.logo-header[data-background-color="light-blue"] {
  background: #48ABF7 !important; }

.logo-header[data-background-color="light-blue2"] {
  background: #3697E1 !important; }

.navbar-header[data-background-color="light-blue"] {
  background: #48ABF7 !important; }

.navbar-header[data-background-color="light-blue2"] {
  background: #3697E1 !important; }

.logo-header[data-background-color="green"] {
  background: #31CE36 !important; }

.logo-header[data-background-color="green2"] {
  background: #2BB930 !important; }

.navbar-header[data-background-color="green"] {
  background: #31CE36 !important; }

.navbar-header[data-background-color="green2"] {
  background: #2BB930 !important; }

.logo-header[data-background-color="orange"] {
  background: #FFAD46 !important; }

.logo-header[data-background-color="orange2"] {
  background: #FF9E27 !important; }

.navbar-header[data-background-color="orange"] {
  background: #FFAD46 !important; }

.navbar-header[data-background-color="orange2"] {
  background: #FF9E27 !important; }

.logo-header[data-background-color="red"] {
  background: #F25961 !important; }

.logo-header[data-background-color="red2"] {
  background: #EA4d56 !important; }

.navbar-header[data-background-color="red"] {
  background: #F25961 !important; }

.navbar-header[data-background-color="red2"] {
  background: #EA4d56 !important; }

.sidebar[data-background-color="grey"] {
  background: #fafafe; }

.sidebar[data-background-color="dark"] {
  background: #1a2035 !important; }
  .sidebar[data-background-color="dark"] .user {
    border-color: rgba(181, 181, 181, 0.1) !important; }
    .sidebar[data-background-color="dark"] .user .info a > span {
      color: #b9babf; }
      .sidebar[data-background-color="dark"] .user .info a > span .user-level {
        color: #8d9498; }
  .sidebar[data-background-color="dark"] .nav > .nav-item.active > a p {
    color: #b9babf !important; }
  .sidebar[data-background-color="dark"] .nav > .nav-item a {
    color: #b9babf !important; }
    .sidebar[data-background-color="dark"] .nav > .nav-item a:hover p, .sidebar[data-background-color="dark"] .nav > .nav-item a:focus p, .sidebar[data-background-color="dark"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] p {
      color: #b9babf !important; }
  .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:hover, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:focus, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #1a2035 !important; }
    .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a p, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a i, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a .caret, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:hover p, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:hover i, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:hover .caret, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:focus p, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:focus i, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a:focus .caret, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="dark"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #1a2035 !important; }
  .sidebar[data-background-color="dark"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="dark"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="dark"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="dark2"] {
  background: #1f283e !important; }
  .sidebar[data-background-color="dark2"] .user {
    border-color: rgba(181, 181, 181, 0.1) !important; }
    .sidebar[data-background-color="dark2"] .user .info a > span {
      color: #b9babf; }
      .sidebar[data-background-color="dark2"] .user .info a > span .user-level {
        color: #8d9498; }
  .sidebar[data-background-color="dark2"] .nav > .nav-item.active > a p {
    color: #b9babf !important; }
  .sidebar[data-background-color="dark2"] .nav > .nav-item a {
    color: #b9babf !important; }
    .sidebar[data-background-color="dark2"] .nav > .nav-item a:hover p, .sidebar[data-background-color="dark2"] .nav > .nav-item a:focus p, .sidebar[data-background-color="dark2"] .nav > .nav-item a[data-toggle=collapse][aria-expanded=true] p {
      color: #b9babf !important; }
  .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:hover, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:focus, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #1f283e !important; }
    .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a p, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a i, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a .caret, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:hover p, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:hover i, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:hover .caret, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:focus p, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:focus i, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a:focus .caret, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="dark2"].sidebar-style-2 .nav .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #1f283e !important; }
  .sidebar[data-background-color="dark2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="dark2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="dark2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="blue"] {
  background: #1572E8 !important; }
  .sidebar[data-background-color="blue"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="blue"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="blue"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="blue"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="blue"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="blue"] .nav .nav-item a p, .sidebar[data-background-color="blue"] .nav .nav-item a i, .sidebar[data-background-color="blue"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="blue"] .nav .nav-item a:hover, .sidebar[data-background-color="blue"] .nav .nav-item a:focus, .sidebar[data-background-color="blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="blue"] .nav .nav-item a:hover p, .sidebar[data-background-color="blue"] .nav .nav-item a:hover i, .sidebar[data-background-color="blue"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="blue"] .nav .nav-item a:focus p, .sidebar[data-background-color="blue"] .nav .nav-item a:focus i, .sidebar[data-background-color="blue"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="blue"] .nav .nav-section .text-section, .sidebar[data-background-color="blue"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="blue"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #1572E8 !important; }
    .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #1572E8 !important; }
  .sidebar[data-background-color="blue"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="blue"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="blue"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="blue2"] {
  background: #1269DB !important; }
  .sidebar[data-background-color="blue2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="blue2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="blue2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="blue2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="blue2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="blue2"] .nav .nav-item a p, .sidebar[data-background-color="blue2"] .nav .nav-item a i, .sidebar[data-background-color="blue2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="blue2"] .nav .nav-item a:hover, .sidebar[data-background-color="blue2"] .nav .nav-item a:focus, .sidebar[data-background-color="blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="blue2"] .nav .nav-item a:hover p, .sidebar[data-background-color="blue2"] .nav .nav-item a:hover i, .sidebar[data-background-color="blue2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="blue2"] .nav .nav-item a:focus p, .sidebar[data-background-color="blue2"] .nav .nav-item a:focus i, .sidebar[data-background-color="blue2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="blue2"] .nav .nav-section .text-section, .sidebar[data-background-color="blue2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="blue2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #1269DB !important; }
    .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #1269DB !important; }
  .sidebar[data-background-color="blue2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="blue2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="blue2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="purple"] {
  background: #6861CE !important; }
  .sidebar[data-background-color="purple"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="purple"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="purple"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="purple"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="purple"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="purple"] .nav .nav-item a p, .sidebar[data-background-color="purple"] .nav .nav-item a i, .sidebar[data-background-color="purple"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="purple"] .nav .nav-item a:hover, .sidebar[data-background-color="purple"] .nav .nav-item a:focus, .sidebar[data-background-color="purple"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="purple"] .nav .nav-item a:hover p, .sidebar[data-background-color="purple"] .nav .nav-item a:hover i, .sidebar[data-background-color="purple"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="purple"] .nav .nav-item a:focus p, .sidebar[data-background-color="purple"] .nav .nav-item a:focus i, .sidebar[data-background-color="purple"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="purple"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="purple"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="purple"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="purple"] .nav .nav-section .text-section, .sidebar[data-background-color="purple"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="purple"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #6861CE !important; }
    .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="purple"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #6861CE !important; }
  .sidebar[data-background-color="purple"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="purple"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="purple"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="purple2"] {
  background: #5C55BF !important; }
  .sidebar[data-background-color="purple2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="purple2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="purple2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="purple2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="purple2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="purple2"] .nav .nav-item a p, .sidebar[data-background-color="purple2"] .nav .nav-item a i, .sidebar[data-background-color="purple2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="purple2"] .nav .nav-item a:hover, .sidebar[data-background-color="purple2"] .nav .nav-item a:focus, .sidebar[data-background-color="purple2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="purple2"] .nav .nav-item a:hover p, .sidebar[data-background-color="purple2"] .nav .nav-item a:hover i, .sidebar[data-background-color="purple2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="purple2"] .nav .nav-item a:focus p, .sidebar[data-background-color="purple2"] .nav .nav-item a:focus i, .sidebar[data-background-color="purple2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="purple2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="purple2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="purple2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="purple2"] .nav .nav-section .text-section, .sidebar[data-background-color="purple2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="purple2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #5C55BF !important; }
    .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="purple2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #5C55BF !important; }
  .sidebar[data-background-color="purple2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="purple2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="purple2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="light-blue"] {
  background: #48ABF7 !important; }
  .sidebar[data-background-color="light-blue"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="light-blue"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="light-blue"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="light-blue"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="light-blue"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="light-blue"] .nav .nav-item a p, .sidebar[data-background-color="light-blue"] .nav .nav-item a i, .sidebar[data-background-color="light-blue"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="light-blue"] .nav .nav-item a:hover, .sidebar[data-background-color="light-blue"] .nav .nav-item a:focus, .sidebar[data-background-color="light-blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="light-blue"] .nav .nav-item a:hover p, .sidebar[data-background-color="light-blue"] .nav .nav-item a:hover i, .sidebar[data-background-color="light-blue"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="light-blue"] .nav .nav-item a:focus p, .sidebar[data-background-color="light-blue"] .nav .nav-item a:focus i, .sidebar[data-background-color="light-blue"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="light-blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="light-blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="light-blue"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="light-blue"] .nav .nav-section .text-section, .sidebar[data-background-color="light-blue"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="light-blue"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #48ABF7 !important; }
    .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="light-blue"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #48ABF7 !important; }
  .sidebar[data-background-color="light-blue"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="light-blue"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="light-blue"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="light-blue2"] {
  background: #3697E1 !important; }
  .sidebar[data-background-color="light-blue2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="light-blue2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="light-blue2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="light-blue2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="light-blue2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="light-blue2"] .nav .nav-item a p, .sidebar[data-background-color="light-blue2"] .nav .nav-item a i, .sidebar[data-background-color="light-blue2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="light-blue2"] .nav .nav-item a:hover, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:focus, .sidebar[data-background-color="light-blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="light-blue2"] .nav .nav-item a:hover p, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:hover i, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:focus p, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:focus i, .sidebar[data-background-color="light-blue2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="light-blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="light-blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="light-blue2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="light-blue2"] .nav .nav-section .text-section, .sidebar[data-background-color="light-blue2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="light-blue2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #3697E1 !important; }
    .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="light-blue2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #3697E1 !important; }
  .sidebar[data-background-color="light-blue2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="light-blue2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="light-blue2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="green"] {
  background: #31CE36 !important; }
  .sidebar[data-background-color="green"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="green"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="green"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="green"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="green"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="green"] .nav .nav-item a p, .sidebar[data-background-color="green"] .nav .nav-item a i, .sidebar[data-background-color="green"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="green"] .nav .nav-item a:hover, .sidebar[data-background-color="green"] .nav .nav-item a:focus, .sidebar[data-background-color="green"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="green"] .nav .nav-item a:hover p, .sidebar[data-background-color="green"] .nav .nav-item a:hover i, .sidebar[data-background-color="green"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="green"] .nav .nav-item a:focus p, .sidebar[data-background-color="green"] .nav .nav-item a:focus i, .sidebar[data-background-color="green"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="green"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="green"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="green"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="green"] .nav .nav-section .text-section, .sidebar[data-background-color="green"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="green"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #31CE36 !important; }
    .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="green"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #31CE36 !important; }
  .sidebar[data-background-color="green"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="green"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="green"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="green2"] {
  background: #2BB930 !important; }
  .sidebar[data-background-color="green2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="green2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="green2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="green2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="green2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="green2"] .nav .nav-item a p, .sidebar[data-background-color="green2"] .nav .nav-item a i, .sidebar[data-background-color="green2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="green2"] .nav .nav-item a:hover, .sidebar[data-background-color="green2"] .nav .nav-item a:focus, .sidebar[data-background-color="green2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="green2"] .nav .nav-item a:hover p, .sidebar[data-background-color="green2"] .nav .nav-item a:hover i, .sidebar[data-background-color="green2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="green2"] .nav .nav-item a:focus p, .sidebar[data-background-color="green2"] .nav .nav-item a:focus i, .sidebar[data-background-color="green2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="green2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="green2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="green2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="green2"] .nav .nav-section .text-section, .sidebar[data-background-color="green2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="green2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #2BB930 !important; }
    .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="green2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #2BB930 !important; }
  .sidebar[data-background-color="green2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="green2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="green2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="orange"] {
  background: #FFAD46 !important; }
  .sidebar[data-background-color="orange"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="orange"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="orange"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="orange"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="orange"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="orange"] .nav .nav-item a p, .sidebar[data-background-color="orange"] .nav .nav-item a i, .sidebar[data-background-color="orange"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="orange"] .nav .nav-item a:hover, .sidebar[data-background-color="orange"] .nav .nav-item a:focus, .sidebar[data-background-color="orange"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="orange"] .nav .nav-item a:hover p, .sidebar[data-background-color="orange"] .nav .nav-item a:hover i, .sidebar[data-background-color="orange"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="orange"] .nav .nav-item a:focus p, .sidebar[data-background-color="orange"] .nav .nav-item a:focus i, .sidebar[data-background-color="orange"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="orange"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="orange"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="orange"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="orange"] .nav .nav-section .text-section, .sidebar[data-background-color="orange"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="orange"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #FFAD46 !important; }
    .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="orange"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #FFAD46 !important; }
  .sidebar[data-background-color="orange"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="orange"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="orange"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="orange2"] {
  background: #FF9E27 !important; }
  .sidebar[data-background-color="orange2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="orange2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="orange2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="orange2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="orange2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="orange2"] .nav .nav-item a p, .sidebar[data-background-color="orange2"] .nav .nav-item a i, .sidebar[data-background-color="orange2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="orange2"] .nav .nav-item a:hover, .sidebar[data-background-color="orange2"] .nav .nav-item a:focus, .sidebar[data-background-color="orange2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="orange2"] .nav .nav-item a:hover p, .sidebar[data-background-color="orange2"] .nav .nav-item a:hover i, .sidebar[data-background-color="orange2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="orange2"] .nav .nav-item a:focus p, .sidebar[data-background-color="orange2"] .nav .nav-item a:focus i, .sidebar[data-background-color="orange2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="orange2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="orange2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="orange2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="orange2"] .nav .nav-section .text-section, .sidebar[data-background-color="orange2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="orange2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #FF9E27 !important; }
    .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="orange2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #FF9E27 !important; }
  .sidebar[data-background-color="orange2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="orange2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="orange2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="red"] {
  background: #F25961 !important; }
  .sidebar[data-background-color="red"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="red"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="red"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="red"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="red"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="red"] .nav .nav-item a p, .sidebar[data-background-color="red"] .nav .nav-item a i, .sidebar[data-background-color="red"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="red"] .nav .nav-item a:hover, .sidebar[data-background-color="red"] .nav .nav-item a:focus, .sidebar[data-background-color="red"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="red"] .nav .nav-item a:hover p, .sidebar[data-background-color="red"] .nav .nav-item a:hover i, .sidebar[data-background-color="red"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="red"] .nav .nav-item a:focus p, .sidebar[data-background-color="red"] .nav .nav-item a:focus i, .sidebar[data-background-color="red"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="red"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="red"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="red"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="red"] .nav .nav-section .text-section, .sidebar[data-background-color="red"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="red"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #F25961 !important; }
    .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="red"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #F25961 !important; }
  .sidebar[data-background-color="red"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="red"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="red"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

.sidebar[data-background-color="red2"] {
  background: #EA4d56 !important; }
  .sidebar[data-background-color="red2"] .user {
    margin-top: 0px;
    padding-top: 12.5px;
    border-top: 1px solid;
    border-color: rgba(255, 255, 255, 0.1) !important; }
    .sidebar[data-background-color="red2"] .user .info a > span {
      color: #fff; }
      .sidebar[data-background-color="red2"] .user .info a > span .user-level {
        color: #eaeaea; }
    .sidebar[data-background-color="red2"] .user .info .caret {
      border-top-color: #fff; }
  .sidebar[data-background-color="red2"] .nav .nav-item a {
    color: #f5f5f5 !important; }
    .sidebar[data-background-color="red2"] .nav .nav-item a p, .sidebar[data-background-color="red2"] .nav .nav-item a i, .sidebar[data-background-color="red2"] .nav .nav-item a .caret {
      color: #f5f5f5 !important; }
    .sidebar[data-background-color="red2"] .nav .nav-item a:hover, .sidebar[data-background-color="red2"] .nav .nav-item a:focus, .sidebar[data-background-color="red2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] {
      color: #fff !important; }
      .sidebar[data-background-color="red2"] .nav .nav-item a:hover p, .sidebar[data-background-color="red2"] .nav .nav-item a:hover i, .sidebar[data-background-color="red2"] .nav .nav-item a:hover .caret, .sidebar[data-background-color="red2"] .nav .nav-item a:focus p, .sidebar[data-background-color="red2"] .nav .nav-item a:focus i, .sidebar[data-background-color="red2"] .nav .nav-item a:focus .caret, .sidebar[data-background-color="red2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="red2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="red2"] .nav .nav-item a[data-toggle=collapse][aria-expanded=true] .caret {
        color: #fff !important; }
  .sidebar[data-background-color="red2"] .nav .nav-section .text-section, .sidebar[data-background-color="red2"] .nav .nav-section .sidebar-mini-icon {
    color: #eaeaea; }
  .sidebar[data-background-color="red2"] .nav .nav-collapse li a .sub-item:before {
    background: #eaeaea; }
  .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:hover, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:focus, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] {
    background: #fff !important;
    color: #EA4d56 !important; }
    .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a p, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a i, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a .caret, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:hover p, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:hover i, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:hover .caret, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:focus p, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:focus i, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a:focus .caret, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] p, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] i, .sidebar[data-background-color="red2"].sidebar-style-2 .nav > .nav-item.active > a[data-toggle=collapse][aria-expanded=true] .caret {
      color: #EA4d56 !important; }
  .sidebar[data-background-color="red2"] .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #f7f7f7; }
  .sidebar[data-background-color="red2"] .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .sidebar[data-background-color="red2"] .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #dcdbdb; }

/*    Avatar    */
.avatar {
  position: relative;
  display: inline-block; }

.avatar-img {
  width: 100%;
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover; }

.avatar-title {
  width: 100%;
  height: 100%;
  background-color: #6861CE;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center; }

.avatar-online::before, .avatar-offline::before, .avatar-away::before {
  position: absolute;
  right: 0;
  bottom: 0;
  width: 25%;
  height: 25%;
  border-radius: 50%;
  content: '';
  border: 2px solid #fff; }

.avatar-online::before {
  background-color: #31CE36; }

.avatar-offline::before {
  background-color: #97a2b1; }

.avatar-away::before {
  background-color: #FFAD46; }

.avatar {
  width: 3rem;
  height: 3rem; }
  .avatar .border {
    border-width: 3px !important; }
  .avatar .rounded {
    border-radius: 6px !important; }
  .avatar .avatar-title {
    font-size: 18px; }

.avatar-xs {
  width: 1.65rem;
  height: 1.65rem; }
  .avatar-xs .border {
    border-width: 2px !important; }
  .avatar-xs .rounded {
    border-radius: 4px !important; }
  .avatar-xs .avatar-title {
    font-size: 12px; }
  .avatar-xs.avatar-online::before, .avatar-xs.avatar-offline::before, .avatar-xs.avatar-away::before {
    border-width: 1px; }

.avatar-sm {
  width: 2.5rem;
  height: 2.5rem; }
  .avatar-sm .border {
    border-width: 3px !important; }
  .avatar-sm .rounded {
    border-radius: 4px !important; }
  .avatar-sm .avatar-title {
    font-size: 15px; }
  .avatar-sm.avatar-online::before, .avatar-sm.avatar-offline::before, .avatar-sm.avatar-away::before {
    border-width: 2px; }

.avatar-lg {
  width: 3.75rem;
  height: 3.75rem; }
  .avatar-lg .border {
    border-width: 3px !important; }
  .avatar-lg .rounded {
    border-radius: 8px !important; }
  .avatar-lg .avatar-title {
    font-size: 24px; }
  .avatar-lg.avatar-online::before, .avatar-lg.avatar-offline::before, .avatar-lg.avatar-away::before {
    border-width: 3px; }

.avatar-xl {
  width: 5rem;
  height: 5rem; }
  .avatar-xl .border {
    border-width: 4px !important; }
  .avatar-xl .rounded {
    border-radius: 8px !important; }
  .avatar-xl .avatar-title {
    font-size: 28px; }
  .avatar-xl.avatar-online::before, .avatar-xl.avatar-offline::before, .avatar-xl.avatar-away::before {
    border-width: 4px; }

.avatar-xxl {
  width: 5.125rem;
  height: 5.125rem; }
  .avatar-xxl .border {
    border-width: 6px !important; }
  .avatar-xxl .rounded {
    border-radius: 8px !important; }
  .avatar-xxl .avatar-title {
    font-size: 30px; }
  .avatar-xxl.avatar-online::before, .avatar-xxl.avatar-offline::before, .avatar-xxl.avatar-away::before {
    border-width: 4px; }

@media (min-width: 768px) {
  .avatar-xxl {
    width: 8rem;
    height: 8rem; }
    .avatar-xxl .border {
      border-width: 4px !important; }
    .avatar-xxl .rounded {
      border-radius: 12px !important; }
    .avatar-xxl .avatar-title {
      font-size: 42px; }
    .avatar-xxl.avatar-online::before, .avatar-xxl.avatar-offline::before, .avatar-xxl.avatar-away::before {
      border-width: 4px; } }
.avatar-group {
  display: inline-flex; }
  .avatar-group .avatar + .avatar {
    margin-left: -.75rem; }
  .avatar-group .avatar-xs + .avatar-xs {
    margin-left: -.40625rem; }
  .avatar-group .avatar-sm + .avatar-sm {
    margin-left: -.625rem; }
  .avatar-group .avatar-lg + .avatar-lg {
    margin-left: -1rem; }
  .avatar-group .avatar-xl + .avatar-xl {
    margin-left: -1.28125rem; }
  .avatar-group .avatar:hover {
    z-index: 1; }

.border-dark {
  border-color: #202940 !important; }

/* 		Breadcrumb		*/
.breadcrumbs {
  list-style: none;
  display: inline;
  width: auto;
  border-left: 1px solid #efefef;
  margin-left: 25px;
  padding-left: 25px;
  margin-bottom: 0px;
  padding-top: 8px;
  padding-bottom: 8px;
  height: 100%; }
  .breadcrumbs li {
    display: inline-block; }
    .breadcrumbs li a {
      color: #2A2F5B;
      font-size: 13px; }
      .breadcrumbs li a i {
        font-size: 16px; }
      .breadcrumbs li a:hover {
        text-decoration: none; }
    .breadcrumbs li.separator {
      padding-left: 10px;
      padding-right: 10px;
      font-size: 12px; }

/*     Card     */
.card, .card-light {
  border-radius: 5px;
  background-color: #ffffff;
  margin-bottom: 30px;
  -webkit-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  -moz-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  border: 0px; }
  .card .card-header, .card-light .card-header {
    padding: 1rem 1.25rem;
    background-color: transparent;
    border-bottom: 1px solid #ebecec !important; }
    .card .card-header:first-child, .card-light .card-header:first-child {
      border-radius: 0px; }
    .card .card-header .card-head-row, .card-light .card-header .card-head-row {
      display: flex;
      align-items: center; }
      .card .card-header .card-head-row .card-tools, .card-light .card-header .card-head-row .card-tools {
        margin-left: auto;
        float: right;
        padding-left: 15px; }
  .card .separator-solid, .card-light .separator-solid {
    border-top: 1px solid #ebecec;
    margin: 15px 0; }
  .card .separator-dashed, .card-light .separator-dashed {
    border-top: 1px dashed #ebecec;
    margin: 15px 0; }
  .card .separator-dot, .card-light .separator-dot {
    border-top: 1px dotted #ebecec;
    margin: 15px 0; }
  .card .full-width-separator, .card-light .full-width-separator {
    margin: 15px -20px 15px; }
  .card .b-b1, .card-light .b-b1 {
    border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
  .card .card-body, .card-light .card-body {
    padding: 1.25rem; }
  .card .card-footer, .card-light .card-footer {
    background-color: transparent;
    line-height: 30px;
    border-top: 1px solid #ebecec !important;
    font-size: 13px; }
  .card .pull-in, .card-light .pull-in {
    margin-left: -1.25rem;
    margin-right: -1.25rem; }
    .card .pull-in.sparkline-fix, .card-light .pull-in.sparkline-fix {
      margin-left: -1.35rem;
      margin-right: -1.35rem;
      margin-bottom: -3px; }
  .card .chart-as-background, .card-light .chart-as-background {
    position: absolute;
    bottom: 0;
    width: calc(100% + 2px); }
  .card .card-action, .card-light .card-action {
    padding: 30px;
    background-color: transparent;
    line-height: 30px;
    border-top: 1px solid #ebecec !important;
    font-size: 14px; }
  .card .card-footer hr, .card-light .card-footer hr {
    margin-top: 5px;
    margin-bottom: 5px; }
  .card .card-footer .legend, .card-light .card-footer .legend {
    display: inline-block; }

@media screen and (max-width: 476px) {
  .card .card-header .card-head-row:not(.card-tools-still-right) {
    flex-direction: column;
    align-items: unset; }
    .card .card-header .card-head-row:not(.card-tools-still-right) .card-tools {
      margin-left: 0px;
      float: left;
      padding-left: 0px;
      padding-top: 10px; } }
.card.full-height {
  height: calc(100% - 30px); }

.card-space {
  padding: 0 30px; }
  .card-space > .card-header, .card-space > .card-body, .card-space > .card-footer, .card-space > .card-action {
    padding-left: 0px !important;
    padding-right: 0px !important; }

.card-with-nav .card-header {
  border-bottom: 0px !important;
  padding-top: 0px !important;
  padding-bottom: 0px !important; }
.card-with-nav .card-body {
  padding: 15px 25px !important; }

.card-list {
  padding: 10px 0; }
  .card-list .item-list {
    display: flex;
    flex-direction: row;
    padding: 10px 0;
    align-items: center; }
    .card-list .item-list .info-user {
      flex: 1; }
      .card-list .item-list .info-user .username, .card-list .item-list .info-user a.username {
        color: #1572E8;
        font-size: 13px;
        margin-bottom: 5px;
        font-weight: 400; }
      .card-list .item-list .info-user .status {
        font-size: 11px;
        color: #7d7b7b; }

.card-title {
  margin: 0;
  color: #2A2F5B;
  font-size: 20px;
  font-weight: 400;
  line-height: 1.6; }
  .card-title a, .card-title a:hover, .card-title a:focus {
    color: #2A2F5B;
    text-decoration: none; }

.card-sub {
  display: block;
  margin: 5px 0 10px 0;
  font-size: .9rem;
  background: #f7f8fa;
  color: #2A2F5B;
  padding: 0.85rem 1.5rem;
  border-radius: 4px;
  line-height: 1.82; }

.card-category {
  margin-top: 8px;
  font-size: 14px;
  color: #8d9498;
  margin-bottom: 0px;
  word-break: normal; }

label {
  font-size: 14px;
  font-weight: 400;
  color: #8d9498;
  margin-bottom: 0px; }

.card-transparent {
  background: transparent !important;
  box-shadow: none;
  border-color: transparent !important; }

/*     Card Stats    */
.card-stats .card-body {
  padding: 15px !important; }
.card-stats .card-title {
  margin-bottom: 0px !important; }
.card-stats .card-category {
  margin-top: 0px; }
.card-stats .col-icon {
  width: 65px;
  height: 65px;
  margin-left: 15px; }
.card-stats .icon-big {
  width: 100%;
  height: 100%;
  font-size: 2.2em;
  min-height: 64px;
  display: flex;
  align-items: center;
  justify-content: center; }
  .card-stats .icon-big.icon-black, .card-stats .icon-big.icon-primary, .card-stats .icon-big.icon-secondary, .card-stats .icon-big.icon-success, .card-stats .icon-big.icon-info, .card-stats .icon-big.icon-warning, .card-stats .icon-big.icon-danger {
    border-radius: 5px; }
    .card-stats .icon-big.icon-black i, .card-stats .icon-big.icon-primary i, .card-stats .icon-big.icon-secondary i, .card-stats .icon-big.icon-success i, .card-stats .icon-big.icon-info i, .card-stats .icon-big.icon-warning i, .card-stats .icon-big.icon-danger i {
      color: #ffffff !important; }
  .card-stats .icon-big.icon-black {
    background: #1a2035; }
  .card-stats .icon-big.icon-primary {
    background: #1572E8; }
  .card-stats .icon-big.icon-secondary {
    background: #6861CE; }
  .card-stats .icon-big.icon-success {
    background: #31CE36; }
  .card-stats .icon-big.icon-warning {
    background: #FFAD46; }
  .card-stats .icon-big.icon-info {
    background: #48ABF7; }
  .card-stats .icon-big.icon-danger {
    background: #F25961; }
  .card-stats .icon-big.round {
    border-radius: 50% !important; }
.card-stats .col-stats {
  align-items: center;
  display: flex;
  padding-left: 15px; }

/*     Card Task     */
.card-tasks .table {
  margin-bottom: 0px; }
  .card-tasks .table .form-check {
    padding: 0 0 0 0.75rem !important; }
    .card-tasks .table .form-check label {
      margin-bottom: 0px !important; }
  .card-tasks .table tbody td:first-child, .card-tasks .table thead th:first-child {
    padding-left: 15px;
    padding-right: 15px; }
  .card-tasks .table tbody td:last-child, .card-tasks .table thead th:last-child {
    padding-right: 15px; }
  .card-tasks .table tbody tr:last-child td {
    border-bottom-width: 0px !important; }
.card-tasks .card-body {
  padding-top: 0px;
  padding-bottom: 0px; }
  .card-tasks .card-body .table td {
    font-size: 13px; }
    .card-tasks .card-body .table td .btn {
      font-size: 15px;
      opacity: 0.7;
      transition: all .3s; }
    .card-tasks .card-body .table td:hover .btn {
      opacity: 1; }
.card-tasks .form-button-action {
  display: block !important; }

/*     Card States    */
.card-dark, .card-black, .card-primary, .card-secondary, .card-info, .card-success, .card-warning, .card-danger {
  color: #ffffff;
  border: 0px !important; }

.card-dark .card-header, .card-black .card-header, .card-primary .card-header, .card-secondary .card-header, .card-info .card-header, .card-success .card-header, .card-warning .card-header, .card-danger .card-header {
  border-bottom: transparent !important; }

.card-dark .card-category, .card-black .card-category, .card-primary .card-category, .card-secondary .card-category, .card-info .card-category, .card-success .card-category, .card-warning .card-category, .card-danger .card-category, .card-dark .card-title, .card-black .card-title, .card-primary .card-title, .card-secondary .card-title, .card-info .card-title, .card-success .card-title, .card-warning .card-title, .card-danger .card-title, .card-dark label, .card-black label, .card-primary label, .card-info label, .card-success label, .card-warning label, .card-danger label {
  color: #ffffff; }

.card-dark .icon-big > i, .card-black .icon-big > i, .card-primary .icon-big > i, .card-secondary .icon-big > i, .card-info .icon-big > i, .card-success .icon-big > i, .card-warning .icon-big > i, .card-danger .icon-big > i {
  color: #ffffff !important; }

.card-dark .card-footer, .card-black .card-footer, .card-primary .card-footer, .card-secondary .card-footer, .card-info .card-footer, .card-success .card-footer, .card-warning .card-footer, .card-danger .card-footer {
  border-top: transparent !important; }

.card-black {
  background: #1a2035 !important; }

.card-primary {
  background: #1572E8 !important; }

.card-secondary {
  background: #6861CE !important; }

.card-info {
  background: #48ABF7 !important; }

.card-success {
  background: #31CE36 !important; }

.card-warning {
  background: #FFAD46 !important; }

.card-danger {
  background: #F25961 !important; }

.card-round {
  border-radius: 5px; }

/*     Progress Card    */
.progress-card {
  margin-bottom: 25px; }
  .progress-card .progress-status {
    display: flex;
    margin-bottom: 10px;
    -webkit-box-pack: justify !important;
    -ms-flex-pack: justify !important;
    justify-content: space-between !important; }

/*      Card Posts    */
.card-post .info-post .username {
  margin-bottom: 0px;
  font-weight: 600; }
.card-post .info-post .date {
  margin-bottom: 0px; }

/*     Card Pricing    */
.card-pricing {
  padding: 20px 5px;
  text-align: center;
  border-radius: 5px; }
  .card-pricing .card-header {
    border-bottom: 0px !important; }
  .card-pricing .card-footer {
    border-top: 0px !important;
    padding: 15px 15px 10px 15px; }
  .card-pricing .card-title {
    font-weight: 400;
    font-size: 20px; }
  .card-pricing .card-price .price {
    font-size: 36px;
    font-weight: 400; }
  .card-pricing .card-price .text {
    font-size: 18px;
    font-weight: 400;
    color: #d1d7e3; }
  .card-pricing .specification-list {
    list-style: none;
    padding-left: 0px; }
    .card-pricing .specification-list li {
      padding: 8px 0 12px;
      border-bottom: 1px solid #eee;
      text-align: left;
      font-size: 12px;
      margin-bottom: 5px; }
      .card-pricing .specification-list li .name-specification {
        color: #83848a; }
      .card-pricing .specification-list li .status-specification {
        margin-left: auto;
        float: right;
        font-weight: 400; }
  .card-pricing.card-pricing-focus {
    padding: 40px 5px; }
  .card-pricing.card-black .name-specification, .card-pricing.card-primary .name-specification, .card-pricing.card-secondary .name-specification, .card-pricing.card-info .name-specification, .card-pricing.card-success .name-specification, .card-pricing.card-danger .name-specification, .card-pricing.card-warning .name-specification {
    color: #ffffff !important; }
  .card-pricing.card-primary .specification-list li {
    border-color: #2f8bff !important; }
  .card-pricing.card-primary .btn-light {
    color: #1572E8 !important; }
  .card-pricing.card-success .specification-list li {
    border-color: #64e069 !important; }
  .card-pricing.card-success .btn-light {
    color: #31CE36 !important; }
  .card-pricing.card-secondary .specification-list li {
    border-color: #7f77dc !important; }
  .card-pricing.card-secondary .btn-light {
    color: #6861CE !important; }
  .card-pricing.card-black .specification-list li {
    border-color: #6f8996 !important; }
  .card-pricing.card-black .btn-light {
    color: #1a2035 !important; }
  .card-pricing.card-info .specification-list li {
    border-color: #11c0e4 !important; }
  .card-pricing.card-info .btn-light {
    color: #48ABF7 !important; }
  .card-pricing.card-danger .specification-list li {
    border-color: #ff6972 !important; }
  .card-pricing.card-danger .btn-light {
    color: #F25961 !important; }
  .card-pricing.card-warning .specification-list li {
    border-color: #ffbc67 !important; }
  .card-pricing.card-warning .btn-light {
    color: #FFAD46 !important; }

.card-pricing2 {
  padding-bottom: 10px;
  background: #fff !important;
  border-bottom: 7px solid;
  text-align: center;
  overflow: hidden;
  position: relative;
  border-radius: 5px;
  -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
  -moz-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
  box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08); }
  .card-pricing2:before {
    content: "";
    width: 100%;
    height: 350px;
    position: absolute;
    top: -150px;
    left: 0;
    transform: skewY(-20deg); }
  .card-pricing2 .price-value:after, .card-pricing2 .price-value:before {
    content: "";
    left: 50%;
    transform: translateX(-50%) scaleY(0.5) rotate(45deg); }
  .card-pricing2 .value:after, .card-pricing2 .value:before {
    content: "";
    left: 50%;
    transform: translateX(-50%) scaleY(0.5) rotate(45deg); }
  .card-pricing2 .pricing-header {
    padding: 20px 20px 60px;
    text-align: left;
    position: relative; }
  .card-pricing2 .sub-title {
    display: block;
    font-size: 16px; }
  .card-pricing2 .value {
    background: #fff; }
  .card-pricing2 .price-value {
    display: inline-block;
    width: 170px;
    height: 110px;
    padding: 15px;
    border: 2px solid;
    border-top: none;
    border-bottom: none;
    position: relative; }
    .card-pricing2 .price-value:after, .card-pricing2 .price-value:before {
      width: 121px;
      height: 121px;
      border: 3px solid;
      border-right: none;
      border-bottom: none;
      position: absolute;
      top: -60px; }
    .card-pricing2 .price-value:after {
      border-top: none;
      border-left: none;
      border-bottom: 3px solid;
      border-right: 3px solid;
      top: auto;
      bottom: -60px; }
  .card-pricing2 .value {
    width: 100%;
    height: 100%;
    border: 2px solid;
    border-top: none;
    border-bottom: none;
    z-index: 1;
    position: relative; }
    .card-pricing2 .value:after, .card-pricing2 .value:before {
      width: 97px;
      height: 97px;
      background: #fff;
      border: 3px solid;
      border-bottom: none;
      border-right: none;
      position: absolute;
      top: -48px;
      z-index: -1; }
    .card-pricing2 .value:after {
      border-right: 3px solid;
      border-bottom: 3px solid;
      border-top: none;
      border-left: none;
      top: auto;
      bottom: -48px; }
  .card-pricing2 .currency {
    display: inline-block;
    font-size: 30px;
    margin-top: 7px;
    vertical-align: top; }
  .card-pricing2 .amount {
    display: inline-block;
    font-size: 40px;
    font-weight: 600;
    line-height: 65px; }
    .card-pricing2 .amount span {
      display: inline-block;
      font-size: 30px;
      font-weight: 400;
      vertical-align: top;
      margin-top: -7px; }
  .card-pricing2 .month {
    display: block;
    font-size: 16px;
    line-height: 0; }
  .card-pricing2 .pricing-content {
    padding: 50px 0 0 80px;
    margin-bottom: 20px;
    list-style: none;
    text-align: left;
    transition: all .3s ease 0s; }
    .card-pricing2 .pricing-content li {
      padding: 7px 0;
      font-size: 13px;
      color: grey;
      position: relative; }
      .card-pricing2 .pricing-content li.disable:before, .card-pricing2 .pricing-content li:before {
        content: "\f00c";
        font-family: 'Font Awesome 5 Solid';
        font-weight: 900;
        width: 20px;
        height: 20px;
        line-height: 20px;
        border-radius: 50%;
        background: #98c458;
        text-align: center;
        color: #fff;
        position: absolute;
        left: -50px;
        font-size: 9px; }
      .card-pricing2 .pricing-content li.disable:before {
        content: "\f00d";
        background: #fe6c6c; }
  .card-pricing2.card-black {
    border-bottom-color: #1a2035; }
    .card-pricing2.card-black .price-value:before, .card-pricing2.card-black .value:before {
      border-left-color: #1a2035;
      border-top-color: #1a2035; }
    .card-pricing2.card-black .price-value, .card-pricing2.card-black .value {
      border-right-color: #1a2035; }
      .card-pricing2.card-black .price-value:after, .card-pricing2.card-black .value:after {
        border-right-color: #1a2035; }
    .card-pricing2.card-black .price-value:after, .card-pricing2.card-black .value:after {
      border-bottom-color: #1a2035; }
    .card-pricing2.card-black .value {
      color: #1a2035; }
    .card-pricing2.card-black:before {
      background: #1a2035; }
    .card-pricing2.card-black .price-value, .card-pricing2.card-black .value {
      border-left-color: #1a2035; }
  .card-pricing2.card-primary {
    border-bottom-color: #1572E8; }
    .card-pricing2.card-primary .price-value:before, .card-pricing2.card-primary .value:before {
      border-left-color: #1572E8;
      border-top-color: #1572E8; }
    .card-pricing2.card-primary .price-value, .card-pricing2.card-primary .value {
      border-right-color: #1572E8; }
      .card-pricing2.card-primary .price-value:after, .card-pricing2.card-primary .value:after {
        border-right-color: #1572E8; }
    .card-pricing2.card-primary .price-value:after, .card-pricing2.card-primary .value:after {
      border-bottom-color: #1572E8; }
    .card-pricing2.card-primary .value {
      color: #1572E8; }
    .card-pricing2.card-primary:before {
      background: #1572E8; }
    .card-pricing2.card-primary .price-value, .card-pricing2.card-primary .value {
      border-left-color: #1572E8; }
  .card-pricing2.card-secondary {
    border-bottom-color: #6861CE; }
    .card-pricing2.card-secondary .price-value:before, .card-pricing2.card-secondary .value:before {
      border-left-color: #6861CE;
      border-top-color: #6861CE; }
    .card-pricing2.card-secondary .price-value, .card-pricing2.card-secondary .value {
      border-right-color: #6861CE; }
      .card-pricing2.card-secondary .price-value:after, .card-pricing2.card-secondary .value:after {
        border-right-color: #6861CE; }
    .card-pricing2.card-secondary .price-value:after, .card-pricing2.card-secondary .value:after {
      border-bottom-color: #6861CE; }
    .card-pricing2.card-secondary .value {
      color: #6861CE; }
    .card-pricing2.card-secondary:before {
      background: #6861CE; }
    .card-pricing2.card-secondary .price-value, .card-pricing2.card-secondary .value {
      border-left-color: #6861CE; }
  .card-pricing2.card-info {
    border-bottom-color: #48ABF7; }
    .card-pricing2.card-info .price-value:before, .card-pricing2.card-info .value:before {
      border-left-color: #48ABF7;
      border-top-color: #48ABF7; }
    .card-pricing2.card-info .price-value, .card-pricing2.card-info .value {
      border-right-color: #48ABF7; }
      .card-pricing2.card-info .price-value:after, .card-pricing2.card-info .value:after {
        border-right-color: #48ABF7; }
    .card-pricing2.card-info .price-value:after, .card-pricing2.card-info .value:after {
      border-bottom-color: #48ABF7; }
    .card-pricing2.card-info .value {
      color: #48ABF7; }
    .card-pricing2.card-info:before {
      background: #48ABF7; }
    .card-pricing2.card-info .price-value, .card-pricing2.card-info .value {
      border-left-color: #48ABF7; }
  .card-pricing2.card-success {
    border-bottom-color: #31CE36; }
    .card-pricing2.card-success .price-value:before, .card-pricing2.card-success .value:before {
      border-left-color: #31CE36;
      border-top-color: #31CE36; }
    .card-pricing2.card-success .price-value, .card-pricing2.card-success .value {
      border-right-color: #31CE36; }
      .card-pricing2.card-success .price-value:after, .card-pricing2.card-success .value:after {
        border-right-color: #31CE36; }
    .card-pricing2.card-success .price-value:after, .card-pricing2.card-success .value:after {
      border-bottom-color: #31CE36; }
    .card-pricing2.card-success .value {
      color: #31CE36; }
    .card-pricing2.card-success:before {
      background: #31CE36; }
    .card-pricing2.card-success .price-value, .card-pricing2.card-success .value {
      border-left-color: #31CE36; }
  .card-pricing2.card-warning {
    border-bottom-color: #FFAD46; }
    .card-pricing2.card-warning .price-value:before, .card-pricing2.card-warning .value:before {
      border-left-color: #FFAD46;
      border-top-color: #FFAD46; }
    .card-pricing2.card-warning .price-value, .card-pricing2.card-warning .value {
      border-right-color: #FFAD46; }
      .card-pricing2.card-warning .price-value:after, .card-pricing2.card-warning .value:after {
        border-right-color: #FFAD46; }
    .card-pricing2.card-warning .price-value:after, .card-pricing2.card-warning .value:after {
      border-bottom-color: #FFAD46; }
    .card-pricing2.card-warning .value {
      color: #FFAD46; }
    .card-pricing2.card-warning:before {
      background: #FFAD46; }
    .card-pricing2.card-warning .price-value, .card-pricing2.card-warning .value {
      border-left-color: #FFAD46; }
  .card-pricing2.card-danger {
    border-bottom-color: #F25961; }
    .card-pricing2.card-danger .price-value:before, .card-pricing2.card-danger .value:before {
      border-left-color: #F25961;
      border-top-color: #F25961; }
    .card-pricing2.card-danger .price-value, .card-pricing2.card-danger .value {
      border-right-color: #F25961; }
      .card-pricing2.card-danger .price-value:after, .card-pricing2.card-danger .value:after {
        border-right-color: #F25961; }
    .card-pricing2.card-danger .price-value:after, .card-pricing2.card-danger .value:after {
      border-bottom-color: #F25961; }
    .card-pricing2.card-danger .value {
      color: #F25961; }
    .card-pricing2.card-danger:before {
      background: #F25961; }
    .card-pricing2.card-danger .price-value, .card-pricing2.card-danger .value {
      border-left-color: #F25961; }

/*    Card Product    */
.row-cardProduct {
  padding: 0 5px;
  white-space: nowrap;
  overflow-x: auto;
  display: block !important;
  margin-right: -2rem;
  width: unset !important; }

.col-cardProduct {
  width: 225px;
  padding: 0 10px;
  display: inline-block; }

.card-product {
  background: #fff;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0px 7px 15px rgba(0, 0, 0, 0.12);
  margin-bottom: 15px; }
  .card-product .product-summary {
    padding: 15px; }

@media screen and (max-width: 768px) {
  .col-cardProduct {
    width: 175px; }

  .card-product .title-product {
    font-size: 14px; }
  .card-product .price-product {
    font-size: 18px; } }
/*     Card Shadow    */
.skew-shadow {
  position: relative;
  overflow: hidden; }
  .skew-shadow:before {
    content: '';
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    width: 50%;
    min-width: 150px;
    height: 100%;
    top: 0;
    right: -25%;
    transform: skewX(-32.5deg); }

.bubble-shadow {
  position: relative;
  overflow: hidden; }
  .bubble-shadow:before {
    position: absolute;
    top: -10%;
    right: -140px;
    width: 300px;
    height: 300px;
    content: "";
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05); }
  .bubble-shadow:after {
    position: absolute;
    top: -65px;
    right: 80px;
    width: 150px;
    height: 150px;
    content: "";
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05); }

.curves-shadow {
  position: relative;
  overflow: hidden; }
  .curves-shadow:before {
    content: '';
    position: absolute;
    background: url(../img/img-shadow.png);
    background-size: cover;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0; }

@media only screen and (max-width: 990px) {
  .card-pricing2 {
    margin-bottom: 30px; } }
@media only screen and (max-width: 767px) {
  .card-pricing2:before {
    transform: skewY(-15deg); } }
/*     Card Annoucement    */
.card-annoucement .card-body {
  padding: 50px 25px; }
.card-annoucement .card-opening {
  font-size: 20px;
  font-weight: 400;
  letter-spacing: 0.01em; }
.card-annoucement .card-desc {
  padding: 15px 0;
  font-size: 16px;
  line-height: 1.65;
  font-weight: 300; }
.card-annoucement.card-primary .btn-light {
  color: #1572E8 !important; }
.card-annoucement.card-success .btn-light {
  color: #31CE36 !important; }
.card-annoucement.card-secondary .btn-light {
  color: #6861CE !important; }
.card-annoucement.card-black .btn-light {
  color: #1a2035 !important; }
.card-annoucement.card-info .btn-light {
  color: #48ABF7 !important; }
.card-annoucement.card-danger .btn-light {
  color: #F25961 !important; }
.card-annoucement.card-warning .btn-light {
  color: #FFAD46 !important; }

/*     Card Profile     */
.card-profile {
  color: #2A2F5B; }
  .card-profile .profile-picture {
    text-align: center;
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    bottom: -41px;
    width: 100%;
    box-sizing: border-box; }
  .card-profile .user-profile .name {
    font-size: 20px;
    font-weight: 400;
    margin-bottom: 5px; }
  .card-profile .user-profile .job {
    color: #83848a;
    margin-bottom: 5px; }
  .card-profile .user-profile .desc {
    color: #bbb;
    margin-bottom: 15px; }
  .card-profile .user-profile .social-media {
    margin-bottom: 20px; }
    .card-profile .user-profile .social-media .btn {
      padding: 5px !important; }
      .card-profile .user-profile .social-media .btn i {
        font-size: 22px !important; }
  .card-profile .user-stats {
    margin-bottom: 10px; }
    .card-profile .user-stats [class^="col"] {
      border-right: 1px solid #ebebeb; }
    .card-profile .user-stats [class^="col"]:last-child {
      border-right: 0px; }
    .card-profile .user-stats .number {
      font-weight: 400;
      font-size: 15px; }
    .card-profile .user-stats .title {
      color: #7d7b7b; }
  .card-profile .card-header {
    border-bottom: 0px;
    height: 100px;
    position: relative; }
  .card-profile .card-body {
    padding-top: 60px; }
  .card-profile .card-footer {
    border-top: 0px; }
  .card-profile.card-secondary .card-header {
    background: #6861CE; }

/*      Row Card No Padding      */
.row-card-no-pd {
  border-radius: 5px;
  margin-left: 0;
  margin-right: 0;
  background: #ffffff;
  margin-bottom: 30px;
  padding-top: 15px;
  padding-bottom: 15px;
  position: relative;
  -webkit-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  -moz-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1);
  border: 0px; }
  .row-card-no-pd .card {
    margin-bottom: 0px;
    border-width: 0px;
    box-shadow: none;
    position: unset; }
    .row-card-no-pd .card .card-header {
      padding-left: 0px !important;
      padding-top: 0px !important;
      padding-right: 0px !important; }
  .row-card-no-pd [class*=col] .card:before {
    position: absolute;
    height: calc(100%);
    width: 1px;
    background: #eee;
    content: '';
    right: 0px; }
  .row-card-no-pd [class*=col]:last-child .card:before {
    width: 0px; }

/*     Accordion     */
.accordion .card {
  border-radius: 5px !important;
  background: #f7f7f7 !important;
  color: #2A2F5B !important;
  border: 0;
  box-shadow: none; }
  .accordion .card .span-icon {
    font-size: 22px;
    padding-left: 15px;
    padding-right: 15px; }
  .accordion .card > .card-header {
    border: 0px !important;
    display: flex;
    flex-direction: row;
    align-items: center;
    cursor: pointer;
    border-radius: 0 !important; }
    .accordion .card > .card-header > .span-mode {
      margin-left: auto; }
      .accordion .card > .card-header > .span-mode:before {
        content: "\f068" !important;
        font-family: 'Font Awesome 5 Solid';
        font-weight: 900;
        font-size: 16px; }
    .accordion .card > .card-header.collapsed > .span-mode:before {
      content: "\f067" !important; }
  .accordion .card .card-body {
    border-top: 1px solid #ebebeb;
    padding: 30px; }
.accordion.accordion-black .card .card-header, .accordion.accordion-black .card .card-header .btn-link, .accordion.accordion-primary .card .card-header, .accordion.accordion-primary .card .card-header .btn-link, .accordion.accordion-secondary .card .card-header, .accordion.accordion-secondary .card .card-header .btn-link, .accordion.accordion-info .card .card-header, .accordion.accordion-info .card .card-header .btn-link, .accordion.accordion-success .card .card-header, .accordion.accordion-success .card .card-header .btn-link, .accordion.accordion-warning .card .card-header, .accordion.accordion-warning .card .card-header .btn-link, .accordion.accordion-danger .card .card-header, .accordion.accordion-danger .card .card-header .btn-link {
  font-size: 14px; }
.accordion.accordion-black .card .card-header {
  color: #1a2035; }
  .accordion.accordion-black .card .card-header .btn-link {
    color: #1a2035 !important; }
.accordion.accordion-primary .card .card-header {
  color: #1572E8; }
  .accordion.accordion-primary .card .card-header .btn-link {
    color: #1572E8 !important; }
.accordion.accordion-secondary .card .card-header {
  color: #6861CE; }
  .accordion.accordion-secondary .card .card-header .btn-link {
    color: #6861CE !important; }
.accordion.accordion-info .card .card-header {
  color: #48ABF7; }
  .accordion.accordion-info .card .card-header .btn-link {
    color: #48ABF7 !important; }
.accordion.accordion-success .card .card-header {
  color: #31CE36; }
  .accordion.accordion-success .card .card-header .btn-link {
    color: #31CE36 !important; }
.accordion.accordion-warning .card .card-header {
  color: #FFAD46; }
  .accordion.accordion-warning .card .card-header .btn-link {
    color: #FFAD46 !important; }
.accordion.accordion-danger .card .card-header {
  color: #F25961; }
  .accordion.accordion-danger .card .card-header .btn-link {
    color: #F25961 !important; }

.border-transparent {
  border-color: transparent !important; }

.gutters-0 {
  margin-right: 0;
  margin-left: 0; }
  .gutters-0 > .col, .gutters-0 > [class*="col-"] {
    padding-right: 0;
    padding-left: 0; }
  .gutters-0 .card {
    margin-bottom: 0; }

.gutters-xs {
  margin-right: -0.25rem;
  margin-left: -0.25rem; }
  .gutters-xs > .col, .gutters-xs > [class*="col-"] {
    padding-right: 0.25rem;
    padding-left: 0.25rem; }
  .gutters-xs .card {
    margin-bottom: 0.5rem; }

.gutters-sm {
  margin-right: -0.5rem;
  margin-left: -0.5rem; }
  .gutters-sm > .col, .gutters-sm > [class*="col-"] {
    padding-right: 0.5rem;
    padding-left: 0.5rem; }
  .gutters-sm .card {
    margin-bottom: 1rem; }

.gutters-lg {
  margin-right: -1rem;
  margin-left: -1rem; }
  .gutters-lg > .col, .gutters-lg > [class*="col-"] {
    padding-right: 1rem;
    padding-left: 1rem; }
  .gutters-lg .card {
    margin-bottom: 2rem; }

.gutters-xl {
  margin-right: -1.5rem;
  margin-left: -1.5rem; }
  .gutters-xl > .col, .gutters-xl > [class*="col-"] {
    padding-right: 1.5rem;
    padding-left: 1.5rem; }
  .gutters-xl .card {
    margin-bottom: 3rem; }

.stamp {
  color: #fff;
  background: #6861CE;
  display: inline-block;
  min-width: 2rem;
  height: 2rem;
  padding: 0 .25rem;
  line-height: 2rem;
  text-align: center;
  border-radius: 3px;
  font-weight: 600; }

.stamp-md {
  min-width: 2.5rem;
  height: 2.5rem;
  line-height: 2.5rem; }

/*     Form     */
.form-control {
  font-size: 14px;
  border-color: #ebedf2;
  padding: .6rem 1rem;
  height: inherit !important; }
  .form-control:focus {
    border-color: #3e93ff; }

/*     Form Control Sizes    */
.form-control-lg, .input-group-lg > .form-control, .input-group-lg > .input-group-append > .btn, .input-group-lg > .input-group-append > .input-group-text, .input-group-lg > .input-group-prepend > .btn, .input-group-lg > .input-group-prepend > .input-group-text {
  padding: .5rem 1rem !important;
  font-size: 1.25rem !important; }

.form-control-sm, .input-group-sm > .form-control, .input-group-sm > .input-group-append > .btn, .input-group-sm > .input-group-append > .input-group-text, .input-group-sm > .input-group-prepend > .btn, .input-group-sm > .input-group-prepend > .input-group-text {
  padding: .25rem .5rem !important;
  font-size: .875rem !important;
  line-height: 1.5; }

.form-control::-webkit-input-placeholder {
  color: inherit;
  opacity: 0.7; }

.form-control:-moz-placeholder {
  color: inherit;
  opacity: 0.7; }

.form-control::-moz-placeholder {
  color: inherit;
  opacity: 0.7; }

.form-control:-ms-input-placeholder {
  color: inherit;
  opacity: 0.7; }

.form-control::-ms-input-placeholder {
  color: inherit;
  opacity: 0.7; }

.input-group-text {
  border-color: #ebedf2 !important; }

.form-button-action {
  display: inline-flex; }

.form-check-label, .form-radio-label {
  margin-right: 15px; }

/*     CheckBox Input    */
.select-all-checkbox + .form-check-sign:before {
  background: #ccc !important;
  border-color: #ccc !important; }

.form-check [type="checkbox"]:not(:checked), .form-check [type="checkbox"]:checked {
  position: absolute;
  left: -9999px; }
.form-check [type="checkbox"]:not(:checked) + .form-check-sign, .form-check [type="checkbox"]:checked + .form-check-sign, .form-check [type="checkbox"] + .form-check-sign {
  position: relative;
  padding-left: 2em;
  color: #2A2F5B;
  cursor: pointer; }
.form-check [type="checkbox"]:not(:checked) + .form-check-sign:before, .form-check [type="checkbox"]:checked + .form-check-sign:before, .form-check [type="checkbox"] + .form-check-sign:before {
  content: '';
  position: absolute;
  left: 0;
  top: 1px;
  width: 16px;
  height: 16px;
  border: 1px solid #ccc;
  background: transparent;
  border-radius: 4px; }
.form-check [type="checkbox"]:not(:checked) + .form-check-sign:after, .form-check [type="checkbox"]:checked + .form-check-sign:after, .form-check [type="checkbox"] + .form-check-sign:after {
  content: "\f00c";
  display: inline-block;
  position: absolute;
  top: -1px;
  left: 2px;
  width: 18px;
  height: 18px;
  text-align: center;
  font-size: 1.3em;
  line-height: 0.8;
  color: #1572E8;
  transition: all .2s;
  font-family: 'Font Awesome 5 Solid'; }
.form-check [type="checkbox"]:not(:checked) + .form-check-sign:after {
  opacity: 0;
  transform: scale(0); }
.form-check [type="checkbox"]:checked + .form-check-sign {
  font-weight: 400; }
  .form-check [type="checkbox"]:checked + .form-check-sign:after {
    opacity: 1;
    transform: scale(1); }
.form-check [type="checkbox"]:disabled:not(:checked) + .form-check-sign:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd; }
.form-check [type="checkbox"]:disabled:checked + .form-check-sign:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd; }
.form-check [type="checkbox"]:disabled:checked + .form-check-sign:after {
  color: #999; }
.form-check [type="checkbox"]:disabled + .form-check-sign {
  color: #aaa; }
.form-check [type="checkbox"]:checked:focus + .form-check-sign:before, .form-check [type="checkbox"]:not(:checked):focus + .form-check-sign:before {
  border: 1px solid #ccc; }

.form-check-sign:hover:before {
  border: 1px solid #ccc !important; }

.form-check {
  padding-left: 0.75rem; }

.form-check-input {
  position: relative;
  margin-top: .3rem; }

/*     Radio Input    */
.form-radio [type="radio"]:not(:checked), .form-radio [type="radio"]:checked {
  position: absolute;
  left: -9999px; }
.form-radio [type="radio"]:not(:checked) + .form-radio-sign, .form-radio [type="radio"]:checked + .form-radio-sign {
  color: #2A2F5B;
  position: relative;
  padding-left: 2em;
  cursor: pointer;
  line-height: 22px;
  font-weight: 400; }
.form-radio [type="radio"]:not(:checked) + .form-radio-sign:before {
  content: "\f18a";
  font-size: 22px;
  font-family: LineAwesome;
  position: absolute;
  left: 0;
  top: auto;
  background: transparent;
  line-height: 1;
  color: #bbb; }
.form-radio [type="radio"]:checked + .form-radio-sign:before {
  content: "\f18a";
  font-size: 22px;
  font-family: LineAwesome;
  position: absolute;
  left: 0;
  top: auto;
  background: transparent;
  line-height: 1;
  display: none; }
.form-radio [type="radio"]:not(:checked) + .form-radio-sign:after, .form-radio [type="radio"]:checked + .form-radio-sign:after {
  content: "\f1bc";
  position: absolute;
  left: 0px;
  top: auto;
  text-align: center;
  font-size: 22px;
  color: #4D7CFE;
  transition: all .2s;
  line-height: 1;
  font-family: LineAwesome; }
.form-radio [type="radio"]:not(:checked) + .form-radio-sign:after {
  opacity: 0;
  transform: scale(0); }
.form-radio [type="radio"]:checked + .form-radio-sign {
  font-weight: 400; }
  .form-radio [type="radio"]:checked + .form-radio-sign:after {
    opacity: 1;
    transform: scale(1); }
.form-radio [type="radio"]:disabled:not(:checked) + .form-radio-sign:before {
  box-shadow: none;
  opacity: 0.65; }
.form-radio [type="radio"]:disabled:checked + .form-radio-sign:before {
  box-shadow: none;
  opacity: 0.65; }
.form-radio [type="radio"]:disabled:checked + .form-radio-sign:after {
  opacity: 0.65; }
.form-radio [type="radio"]:disabled + .form-radio-sign {
  color: #aaa;
  opacity: 0.65; }
.form-radio [type="radio"]:checked:focus + .form-radio-sign:before, .form-radio [type="radio"]:not(:checked):focus + .form-radio-sign:before {
  border: 1px solid #ccc; }

.form-radio {
  padding-left: 0.75rem; }

.form-radio-input {
  position: relative;
  margin-top: .3rem; }

/*      Custom Checkbox      */
.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #1572E8; }
.custom-checkbox.checkbox-black .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #1a2035; }
.custom-checkbox.checkbox-primary .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #1572E8; }
.custom-checkbox.checkbox-secondary .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #6861CE; }
.custom-checkbox.checkbox-info .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #48ABF7; }
.custom-checkbox.checkbox-success .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #31CE36; }
.custom-checkbox.checkbox-warning .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #FFAD46; }
.custom-checkbox.checkbox-danger .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #F25961; }

/*      Label      */
.col-form-label {
  line-height: 1.8; }

.required-label {
  color: red; }

.label-align-left {
  text-align: left; }

.label-align-right {
  text-align: right; }

.label-align-center {
  text-align: center; }

/*     Input    */
.form-group, .form-check {
  margin-bottom: 0;
  padding: 10px; }

.form-group label, .form-check label {
  margin-bottom: .5rem;
  color: #495057;
  font-weight: 600;
  font-size: 1rem;
  white-space: nowrap; }

.form-group-default {
  background-color: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.07);
  border-radius: 4px;
  padding-top: 7px;
  padding-left: 12px;
  padding-right: 12px;
  padding-bottom: 4px;
  overflow: hidden;
  width: 100%;
  -webkit-transition: background-color .2s ease;
  transition: background-color .2s ease;
  margin-bottom: 15px; }
  .form-group-default label {
    opacity: 1;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    backface-visibility: hidden;
    margin: 0;
    display: block;
    -webkit-transition: opacity .2s ease;
    transition: opacity .2s ease; }
  .form-group-default label:not(.error) {
    font-size: 10.5px !important;
    letter-spacing: .06em;
    text-transform: uppercase;
    font-weight: 400; }
  .form-group-default .form-control {
    border: 0;
    min-height: 25px;
    padding: 0;
    margin-top: 6px;
    background: 0 0;
    font-size: 14px; }
  .form-group-default select.form-control:not([size]):not([multiple]) {
    height: unset !important; }
  .form-group-default.active {
    border-color: rgba(0, 0, 0, 0.1) !important;
    background-color: #f0f0f0; }
    .form-group-default.active label {
      opacity: 0.5; }

.form-floating-label {
  position: relative; }
  .form-floating-label .placeholder {
    position: absolute;
    padding: .375rem .75rem;
    transition: all .2s;
    opacity: 0.8;
    margin-bottom: 0 !important;
    font-size: 14px !important;
    font-weight: 400;
    top: 12px; }
  .form-floating-label .form-control:focus + .placeholder, .form-floating-label .form-control:valid + .placeholder, .form-floating-label .form-control.filled + .placeholder {
    font-size: 85% !important;
    transform: translate3d(0, -10px, 0);
    top: 0;
    opacity: 1;
    padding: .375rem 0 .75rem;
    font-weight: 600; }
  .form-floating-label .form-control.filled + .placeholder {
    color: #1572E8 !important; }
  .form-floating-label .form-control ::-webkit-input-placeholder {
    color: transparent; }
  .form-floating-label .form-control :-moz-placeholder {
    color: transparent; }
  .form-floating-label .form-control ::-moz-placeholder {
    color: transparent; }
  .form-floating-label .form-control :-ms-input-placeholder {
    color: transparent; }
  .form-floating-label .input-border-bottom + .placeholder {
    padding: .375rem 0 .75rem; }

.form-inline label {
  margin-bottom: 0 !important; }

.input-fixed {
  width: 200px; }

.form-control.input-full {
  width: 100% !important; }

.has-success label {
  color: #31CE36 !important; }
.has-success .form-control {
  border-color: #31CE36 !important;
  color: #31CE36 !important; }
.has-success .input-group-text {
  border-color: #31CE36 !important;
  background: #31CE36 !important;
  color: #ffffff !important; }

.has-error label {
  color: #F25961 !important; }
.has-error .form-control {
  border-color: #F25961 !important;
  color: #F25961 !important; }
.has-error .input-group-text {
  border-color: #F25961 !important;
  background: #F25961 !important;
  color: #ffffff !important; }

.input-group label.error, .input-group label.success {
  width: 100%;
  order: 100; }

.custom-control {
  position: relative; }
  .custom-control.custom-radio, .custom-control.custom-checkbox {
    margin-bottom: 0;
    padding-left: 2em;
    cursor: pointer;
    line-height: 24px;
    margin-right: 25px;
    display: inline-block; }
    .custom-control.custom-radio label.error, .custom-control.custom-radio label.success, .custom-control.custom-checkbox label.error, .custom-control.custom-checkbox label.success {
      position: absolute;
      width: 100vh;
      top: 23px;
      left: 0; }

.has-feedback {
  position: relative; }

.form-control-feedback {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 20px; }

.has-success .form-control-feedback {
  color: #31CE36; }

.has-error .form-control-feedback {
  color: #F25961; }

.input-group.has-icon {
  border-radius: .25rem;
  border: 1px solid #ced4da; }
.input-group.has-success, .input-group.has-icon.has-success {
  border: 1px solid #31CE36 !important;
  color: #31CE36; }
.input-group.has-error {
  border: 1px solid #F25961 !important;
  color: #F25961; }
.input-group.has-icon.has-error {
  border: 1px solid #F25961 !important;
  color: #F25961; }
.input-group.has-icon .form-control {
  border-radius: .25rem;
  border: 0px;
  position: relative; }
.input-group.has-icon .input-group-icon {
  background: transparent;
  border: 0px; }

.input-square {
  border-radius: 0px !important; }

.input-pill {
  border-radius: 1.3rem !important; }

.input-solid {
  background: #e8e8e8 !important;
  border-color: #e8e8e8 !important; }

.input-border-bottom {
  border-width: 0 0 1px 0;
  border-radius: 0px;
  padding: .75rem 0;
  background: transparent !important; }

/*      Input File      */
.input-file input[type="file"], .input-file .form-control, .input-file .form-control-file {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1; }
.input-file label.error, .input-file label.success {
  display: block; }
.input-file input[type="file"] + label:not(.error), .input-file .form-control + label:not(.error), .input-file .form-control-file + label:not(.error), .input-file .label-input-file {
  font-weight: 600;
  letter-spacing: 0.02em;
  color: white !important;
  display: inline-block; }
.input-file.input-file-image img.img-upload-preview {
  max-width: 100%;
  display: block;
  margin-bottom: 15px;
  box-shadow: 0 1px 15px 1px rgba(39, 39, 39, 0.1); }
  .input-file.input-file-image img.img-upload-preview.img-circle {
    border-radius: 2000px; }

.form-control:disabled, .form-control[readonly] {
  background: #e8e8e8 !important;
  border-color: #e8e8e8 !important; }
.form-control:disabled, .form-control[readonly] {
  opacity: 0.6 !important; }

/*    Input Group    */
.input-group-text {
  font-size: 14px; }
  .input-group-text i.la {
    font-size: 21px; }
  .input-group-text i[class*="flaticon"] {
    font-size: 17px; }

/*    Input Icon */
.input-icon {
  position: relative; }
  .input-icon .form-control:not(:first-child) {
    padding-left: 2.5rem; }
  .input-icon .form-control:not(:last-child) {
    padding-right: 2.5rem; }
  .input-icon .input-icon-addon {
    position: absolute;
    left: 1rem;
    top: 0;
    height: 100%;
    display: flex;
    align-items: center; }
    .input-icon .input-icon-addon:last-child {
      left: auto;
      right: 1rem; }

/*     Label States      */
label.error {
  color: #F25961 !important;
  font-size: 80% !important;
  margin-top: .5rem; }

/*     Label states for select2      */
.select2-input {
  position: relative; }
  .select2-input label.error, .select2-input label.success {
    position: absolute;
    bottom: -30px; }
  .select2-input .select2 {
    margin-bottom: 15px; }

/*      Custom Dropzone      */
.dropzone {
  padding: 70px 60px 80px !important;
  border: 2px dashed rgba(0, 0, 0, 0.13) !important;
  background: transparent !important; }
  .dropzone:hover {
    background: #fafafa !important;
    transition: all .5s !important; }
  .dropzone .dz-message .icon {
    margin-bottom: 15px;
    font-size: 39px; }
  .dropzone .dz-message .message {
    font-size: 34px;
    font-weight: 200; }
  .dropzone .dz-message .note {
    font-size: 16px;
    margin-top: 18px;
    font-weight: 300; }

/*      Custom Summernote     */
.note-editor.note-frame {
  border: 0px !important;
  box-shadow: none !important; }
  .note-editor.note-frame .note-toolbar {
    padding: 0 !important;
    border-bottom: 0px !important; }
  .note-editor.note-frame .note-btn {
    border: 1px solid #eee !important;
    background: #fafafa !important; }
  .note-editor.note-frame .note-placeholder {
    margin-top: 15px !important; }
  .note-editor.note-frame .note-codable {
    margin-top: 15px !important; }
  .note-editor.note-frame .note-editing-area .note-editable {
    margin-top: 15px !important;
    border: 1px solid #eee !important; }

/*     Table    */
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
  vertical-align: middle; }
.table > tbody > tr > td, .table > tbody > tr > th {
  padding: 8px; }
.table > tfoot > tr > td, .table > tfoot > tr > th {
  padding: 8px; }
.table thead th {
  border-bottom-width: 2px;
  font-weight: 600; }
.table td, .table th {
  font-size: 14px;
  border-top-width: 0px;
  border-bottom: 1px solid;
  border-color: #ebedf2 !important;
  padding: 0 25px !important;
  height: 60px;
  vertical-align: middle !important; }

/* table full-width */
.table-full-width {
  margin-left: -15px;
  margin-right: -15px; }

/* table bordered states */
.table-bordered-bd-black td, .table-bordered-bd-black th {
  border: 1px solid #1a2035 !important; }

.table-bordered-bd-primary td, .table-bordered-bd-primary th {
  border: 1px solid #1572E8 !important; }

.table-bordered-bd-secondary td, .table-bordered-bd-secondary th {
  border: 1px solid #6861CE !important; }

.table-bordered-bd-info td, .table-bordered-bd-info th {
  border: 1px solid #48ABF7 !important; }

.table-bordered-bd-success td, .table-bordered-bd-success th {
  border: 1px solid #31CE36 !important; }

.table-bordered-bd-warning td, .table-bordered-bd-warning th {
  border: 1px solid #FFAD46 !important; }

.table-bordered-bd-danger td, .table-bordered-bd-danger th {
  border: 1px solid #F25961 !important; }

.table-striped td, .table-striped th {
  border-top: 0 !important;
  border-bottom: 0 !important; }

/* table head background states*/
.table-head-bg-black thead {
  border: 1px solid #1a2035 !important; }

.table-head-bg-primary thead {
  border: 1px solid #1572E8 !important; }

.table-head-bg-secondary thead {
  border: 1px solid #6861CE !important; }

.table-head-bg-info thead {
  border: 1px solid #48ABF7 !important; }

.table-head-bg-success thead {
  border: 1px solid #31CE36 !important; }

.table-head-bg-warning thead {
  border: 1px solid #FFAD46 !important; }

.table-head-bg-danger thead {
  border: 1px solid #F25961 !important; }

.table-head-bg-black thead th, .table-striped-bg-black tbody tr:nth-of-type(odd) {
  background: #1a2035 !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-primary thead th, .table-striped-bg-primary tbody tr:nth-of-type(odd) {
  background: #1572E8 !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-secondary thead th, .table-striped-bg-secondary tbody tr:nth-of-type(odd) {
  background: #6861CE !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-info thead th, .table-striped-bg-info tbody tr:nth-of-type(odd) {
  background: #48ABF7 !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-success thead th, .table-striped-bg-success tbody tr:nth-of-type(odd) {
  background: #31CE36 !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-warning thead th, .table-striped-bg-warning tbody tr:nth-of-type(odd) {
  background: #FFAD46 !important;
  color: #ffffff !important;
  border: 0px !important; }

.table-head-bg-danger thead th, .table-striped-bg-danger tbody tr:nth-of-type(odd) {
  background: #F25961 !important;
  color: #ffffff !important;
  border: 0px !important; }

/* table-responsive */
.table-responsive {
  width: 100% !important;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  -ms-overflow-style: -ms-autohiding-scrollbar; }

/*     Navbar     */
.navbar .navbar-nav .nav-item {
  margin-right: 10px; }
  .navbar .navbar-nav .nav-item:last-child {
    margin-right: 0px; }
  .navbar .navbar-nav .nav-item .nav-link {
    display: inline-block;
    vertical-align: middle;
    color: #666;
    letter-spacing: 0.04em;
    padding: 10px;
    border-radius: 3px;
    position: relative;
    font-size: 14px;
    font-weight: 400;
    text-align: center; }
    .navbar .navbar-nav .nav-item .nav-link:hover, .navbar .navbar-nav .nav-item .nav-link:focus {
      background: #eee; }
    .navbar .navbar-nav .nav-item .nav-link i {
      font-size: 17px;
      vertical-align: middle;
      line-height: 1 !important; }
  .navbar .navbar-nav .nav-item.active .nav-link {
    background: #eee; }

.navbar-expand-lg .navbar-nav .dropdown-menu {
  left: auto;
  right: 0;
  z-index: 1001; }

.dropdown-item {
  font-size: 13px; }

.navbar .navbar-nav .notification {
  position: absolute;
  background-color: #31CE36;
  text-align: center;
  border-radius: 10px;
  min-width: 17px;
  height: 17px;
  font-size: 10px;
  color: #ffffff;
  font-weight: 300;
  line-height: 17px;
  top: 3px;
  right: 3px;
  letter-spacing: -1px; }

.navbar-header {
  padding: 0px 15px; }
  .navbar-header .container-fluid {
    min-height: inherit; }
  .navbar-header .dropdown-toggle::after {
    margin-left: 0; }

.profile-pic:hover, .profile-pic:focus {
  text-decoration: none; }

.navbar-header .dropdown-toggle::after {
  vertical-align: middle;
  color: #555; }

.hidden-caret .dropdown-toggle::after {
  display: none !important; }

.profile-pic span {
  font-size: 14px; }

.navbar[class*="bg-"] {
  border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
  border-left: 1px solid rgba(255, 255, 255, 0.1) !important; }
  .navbar[class*="bg-"] .navbar-brand {
    color: #ffffff; }
  .navbar[class*="bg-"] .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E"); }
  .navbar[class*="bg-"] .navbar-nav > .nav-item > .nav-link {
    color: #ffffff; }
    .navbar[class*="bg-"] .navbar-nav > .nav-item > .nav-link.disabled {
      color: #d8d8d8 !important; }
    .navbar[class*="bg-"] .navbar-nav > .nav-item > .nav-link:hover {
      background: rgba(255, 255, 255, 0.22) !important; }
  .navbar[class*="bg-"] .navbar-nav > .nav-item.active > .nav-link {
    background: rgba(255, 255, 255, 0.22) !important; }
  .navbar[class*="bg-"] .btn-toggle {
    background: rgba(19, 19, 19, 0.25) !important;
    color: #ffffff !important; }
  .navbar[class*="bg-"] .nav-search .input-group {
    border: 0;
    background: rgba(19, 19, 19, 0.25) !important; }
    .navbar[class*="bg-"] .nav-search .input-group .form-control {
      color: #ffffff !important; }
  .navbar[class*="bg-"] .nav-search .search-icon {
    color: #ffffff !important; }

/*    Navbar Line     */
.navbar-line {
  min-height: inherit; }
  .navbar-line .navbar-nav {
    min-height: inherit; }
    .navbar-line .navbar-nav.page-navigation .nav-item {
      min-height: 100%;
      display: flex;
      align-items: center; }

.navbar-line .navbar-nav.page-navigation .nav-item .nav-link {
  padding: 10px 20px;
  background: transparent !important;
  font-weight: 600; }
  .navbar-line .navbar-nav.page-navigation .nav-item .nav-link:first-child {
    margin-left: -20px; }
.navbar-line .navbar-nav.page-navigation .nav-item.active {
  position: relative; }
  .navbar-line .navbar-nav.page-navigation .nav-item.active::after {
    height: 3px;
    width: calc(100% - 40px);
    bottom: 0px;
    transform: translateX(-50%);
    left: 50%;
    background: #1572E8;
    content: '';
    position: absolute; }
    .navbar-line .navbar-nav.page-navigation .nav-item.active::after .nav-link {
      color: #fff !important; }
  .navbar-line .navbar-nav.page-navigation .nav-item.active:first-child::after {
    width: calc(100% - 20px);
    margin-left: -10px; }
.navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link {
  font-weight: 400;
  color: rgba(255, 255, 255, 0.85) !important;
  transition: all .3s; }
  .navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link:hover {
    color: #fff !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-black .nav-item.active::after {
  background: #1a2035 !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-primary .nav-item.active::after {
  background: #1572E8 !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-secondary .nav-item.active::after {
  background: #6861CE !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-success .nav-item.active::after {
  background: #31CE36 !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-warning .nav-item.active::after {
  background: #FFAD46 !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-danger .nav-item.active::after {
  background: #F25961 !important; }
.navbar-line .navbar-nav.page-navigation.page-navigation-info .nav-item.active::after {
  background: #48ABF7 !important; }

.navbar-header:not([data-background-color]) .navbar-line .navbar-nav.page-navigation .active .nav-link, .navbar-header[data-background-color="white"] .navbar-line .navbar-nav.page-navigation .active .nav-link {
  color: #666; }
.navbar-header:not([data-background-color]) .navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link, .navbar-header[data-background-color="white"] .navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link {
  color: #9EA2AD !important; }
  .navbar-header:not([data-background-color]) .navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link:hover, .navbar-header[data-background-color="white"] .navbar-line .navbar-nav.page-navigation .nav-item:not(.active) .nav-link:hover {
    color: #666 !important; }

/*     Nav Search     */
.nav-search .input-group {
  border: 1px solid #eee;
  background: #eee;
  border-radius: 5px; }
  .nav-search .input-group:hover, .nav-search .input-group:focus {
    border: 1px solid #ddd; }
.nav-search.nav-search-round .input-group {
  border-radius: 50px; }
.nav-search .form-control {
  border: 0;
  background: transparent !important;
  font-size: 14px;
  padding: 0.75em 1em;
  min-width: 200px;
  max-width: 100%; }
.nav-search .input-group-text {
  border: 0;
  background: transparent; }
.nav-search .search-icon {
  font-size: 18px;
  color: #8d9498; }
.nav-search .btn-search {
  background: transparent;
  padding: .375rem 1rem; }

/*    Quick Search    */
.quick-search {
  display: flex;
  align-items: center;
  width: 225px; }
  .quick-search .input-group {
    background: #eee;
    border-radius: 5px; }
  .quick-search .btn-search {
    background: transparent;
    padding: .5rem 1rem; }
  .quick-search .search-icon {
    font-size: 16px; }
  .quick-search input.form-control {
    background: transparent;
    border: 0;
    padding: .5rem 0; }

/*     Dropdown Search     */
.dropdown-search {
  min-width: 350px;
  padding: 5px 0; }
  .dropdown-search .nav-search .input-group {
    background: transparent !important;
    box-shadow: none !important;
    border: 0 !important; }
    .dropdown-search .nav-search .input-group .form-control {
      color: inherit !important; }
      .dropdown-search .nav-search .input-group .form-control::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
        color: #bfbfbf !important; }
      .dropdown-search .nav-search .input-group .form-control::-moz-placeholder {
        /* Firefox 19+ */
        color: #bfbfbf !important; }
      .dropdown-search .nav-search .input-group .form-control:-ms-input-placeholder {
        /* IE 10+ */
        color: #bfbfbf !important; }
      .dropdown-search .nav-search .input-group .form-control:-moz-placeholder {
        /* Firefox 18- */
        color: #bfbfbf !important; }

/*     Badge    */
.badge {
  border-radius: 50px;
  margin-left: auto;
  line-height: 1;
  padding: 6px 10px;
  vertical-align: middle;
  font-weight: 400;
  font-size: 11px;
  border: 1px solid #ddd; }

[class*="badge-"]:not(.badge-count) {
  border: 0px !important; }

.badge-black {
  background: #1a2035;
  color: #ffffff !important; }

.badge-primary {
  background: #1572E8; }

.badge-secondary {
  background: #6861CE; }

.badge-info {
  background: #48ABF7; }

.badge-success {
  background-color: #31CE36; }

.badge-warning {
  background: #FFAD46;
  color: #ffffff !important; }

.badge-danger {
  background-color: #F25961; }

/*     Dropdown    */
.dropdown-menu {
  border: 0px;
  border-radius: 3px;
  box-shadow: 0 1px 11px rgba(0, 0, 0, 0.15) !important;
  padding-bottom: 8px;
  margin-top: 3px; }

/*     Notification dropdown    */
.dropdown-title {
  border-bottom: 1px solid #f1f1f1;
  color: #444444;
  font-size: 14px;
  font-weight: 600;
  padding: 12px 15px;
  text-align: center; }

.notif-box, .messages-notif-box {
  width: 280px;
  padding: 0 !important; }
  .notif-box .notif-center a, .messages-notif-box .notif-center a {
    display: flex;
    color: #4d585f; }
    .notif-box .notif-center a:hover, .messages-notif-box .notif-center a:hover {
      text-decoration: none;
      background: #fafafa;
      transition: all .2s; }
    .notif-box .notif-center a .notif-icon, .messages-notif-box .notif-center a .notif-icon {
      display: inline-flex;
      width: 40px;
      height: 40px;
      margin: 10px;
      align-items: center;
      justify-content: center;
      background: #eee;
      border-radius: 50%; }
    .notif-box .notif-center a .notif-img, .messages-notif-box .notif-center a .notif-img {
      display: inline-flex;
      width: 40px;
      height: 40px;
      margin: 10px;
      align-items: center;
      justify-content: center;
      background: #eee;
      border-radius: 50%; }
      .notif-box .notif-center a .notif-img img, .messages-notif-box .notif-center a .notif-img img {
        width: 100%;
        height: 100%;
        border-radius: 50%; }
    .notif-box .notif-center a .notif-icon.notif-black, .notif-box .notif-center a .notif-icon.notif-primary, .notif-box .notif-center a .notif-icon.notif-secondary, .notif-box .notif-center a .notif-icon.notif-info, .notif-box .notif-center a .notif-icon.notif-success, .notif-box .notif-center a .notif-icon.notif-warning, .notif-box .notif-center a .notif-icon.notif-danger, .messages-notif-box .notif-center a .notif-icon.notif-black, .messages-notif-box .notif-center a .notif-icon.notif-primary, .messages-notif-box .notif-center a .notif-icon.notif-secondary, .messages-notif-box .notif-center a .notif-icon.notif-info, .messages-notif-box .notif-center a .notif-icon.notif-success, .messages-notif-box .notif-center a .notif-icon.notif-warning, .messages-notif-box .notif-center a .notif-icon.notif-danger {
      color: #ffffff !important; }
    .notif-box .notif-center a .notif-icon.notif-black, .messages-notif-box .notif-center a .notif-icon.notif-black {
      background: #1a2035 !important; }
    .notif-box .notif-center a .notif-icon.notif-primary, .messages-notif-box .notif-center a .notif-icon.notif-primary {
      background: #1572E8 !important; }
    .notif-box .notif-center a .notif-icon.notif-secondary, .messages-notif-box .notif-center a .notif-icon.notif-secondary {
      background: #6861CE !important; }
    .notif-box .notif-center a .notif-icon.notif-info, .messages-notif-box .notif-center a .notif-icon.notif-info {
      background: #48ABF7 !important; }
    .notif-box .notif-center a .notif-icon.notif-success, .messages-notif-box .notif-center a .notif-icon.notif-success {
      background: #31CE36 !important; }
    .notif-box .notif-center a .notif-icon.notif-warning, .messages-notif-box .notif-center a .notif-icon.notif-warning {
      background: #FFAD46 !important; }
    .notif-box .notif-center a .notif-icon.notif-danger, .messages-notif-box .notif-center a .notif-icon.notif-danger {
      background: #F25961 !important; }
    .notif-box .notif-center a .notif-icon i, .messages-notif-box .notif-center a .notif-icon i {
      font-size: 15px; }
    .notif-box .notif-center a .notif-content, .messages-notif-box .notif-center a .notif-content {
      padding: 10px 15px 10px 0; }
    .notif-box .notif-center a .message-content, .messages-notif-box .notif-center a .message-content {
      padding: 7px 15px 10px 0; }
    .notif-box .notif-center a .notif-content .subject, .messages-notif-box .notif-center a .notif-content .subject {
      font-size: 13px;
      font-weight: 600;
      display: block;
      margin-bottom: 2px; }
    .notif-box .notif-center a .notif-content .block, .messages-notif-box .notif-center a .notif-content .block {
      font-size: 13px;
      line-height: 20px;
      display: block; }
    .notif-box .notif-center a .notif-content .time, .messages-notif-box .notif-center a .notif-content .time {
      color: #7d8c95;
      font-size: 11px; }
  .notif-box .see-all, .messages-notif-box .see-all {
    border-top: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    color: #555;
    font-size: 13px;
    font-weight: 400;
    text-decoration: none; }
    .notif-box .see-all:hover, .messages-notif-box .see-all:hover {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      color: #555;
      font-size: 13px;
      font-weight: 400;
      text-decoration: none; }
    .notif-box .see-all i, .messages-notif-box .see-all i {
      float: right; }

.notif-box .notif-scroll {
  max-height: 256px; }

.messages-notif-box .message-notif-scroll {
  max-height: 250px; }
.messages-notif-box .notif-center a {
  border-bottom: 1px solid #f1f1f1; }
  .messages-notif-box .notif-center a:last-child {
    border-bottom: 0px; }
  .messages-notif-box .notif-center a .notif-content {
    padding: 7px 15px 7px 5px; }

/*     User Dropdown    */
.dropdown-user {
  width: 260px; }

.user-box {
  display: flex;
  padding: .25rem 1rem; }
  .user-box .u-text {
    padding: 0 10px; }
    .user-box .u-text h4 {
      margin-bottom: 5px;
      margin-top: 4px;
      font-size: 14px;
      font-weight: 400;
      line-height: 1; }
    .user-box .u-text .text-muted {
      font-size: 12px;
      margin-bottom: 5px; }
    .user-box .u-text .btn {
      font-size: 11px; }

.caret {
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: .255em;
  vertical-align: .255em;
  content: "";
  border-top: .3em solid;
  border-right: 0.3em solid transparent;
  border-bottom: 0;
  border-left: 0.3em solid transparent; }

/* Quick Actions Dropdown */
.quick-actions {
  width: 350px;
  padding: 0px; }
  .quick-actions:after {
    border-bottom-color: #1572E8 !important; }
  .quick-actions .quick-actions-header {
    display: flex;
    align-items: center;
    flex-direction: column;
    background: #1572E8;
    color: #fff;
    padding: 15px;
    border-radius: 3px 3px 0 0; }
    .quick-actions .quick-actions-header .title {
      font-size: 16px; }
    .quick-actions .quick-actions-header .subtitle {
      font-size: 13px; }
  .quick-actions .quick-actions-items {
    padding: 7.5px 0; }
  .quick-actions a:hover {
    text-decoration: none; }
  .quick-actions .quick-actions-item {
    display: flex;
    flex-direction: column;
    margin: 7.5px 10px;
    padding: 10px;
    align-items: center;
    color: #1572E8; }
    .quick-actions .quick-actions-item i {
      color: #fff;
      font-size: 18px; }
    .quick-actions .quick-actions-item .text {
      text-align: center;
      font-size: 14px;
      margin-top: 12px; }
    .quick-actions .quick-actions-item:hover .avatar-item {
      transform: scale(1.1); }
  .quick-actions .avatar-item {
    display: inline-flex;
    width: 48px;
    height: 48px;
    color: #fff;
    border-radius: .375rem;
    background-color: #1572E8;
    align-items: center;
    justify-content: center;
    transition: all .15s;
    box-shadow: 2px 2px 8px 0px rgba(31, 30, 30, 0.13) !important; }
  .quick-actions.quick-actions-black:after {
    border-bottom-color: #1a2035 !important; }
  .quick-actions.quick-actions-black .quick-actions-header {
    background: #1a2035; }
  .quick-actions.quick-actions-black .quick-actions-item {
    color: #1a2035; }
  .quick-actions.quick-actions-primary:after {
    border-bottom-color: #1572E8 !important; }
  .quick-actions.quick-actions-primary .quick-actions-header {
    background: #1572E8; }
  .quick-actions.quick-actions-primary .quick-actions-item {
    color: #1572E8; }
  .quick-actions.quick-actions-secondary:after {
    border-bottom-color: #6861CE !important; }
  .quick-actions.quick-actions-secondary .quick-actions-header {
    background: #6861CE; }
  .quick-actions.quick-actions-secondary .quick-actions-item {
    color: #6861CE; }
  .quick-actions.quick-actions-info:after {
    border-bottom-color: #48ABF7 !important; }
  .quick-actions.quick-actions-info .quick-actions-header {
    background: #48ABF7; }
  .quick-actions.quick-actions-info .quick-actions-item {
    color: #48ABF7; }
  .quick-actions.quick-actions-warning:after {
    border-bottom-color: #FFAD46 !important; }
  .quick-actions.quick-actions-warning .quick-actions-header {
    background: #FFAD46; }
  .quick-actions.quick-actions-warning .quick-actions-item {
    color: #FFAD46; }
  .quick-actions.quick-actions-success:after {
    border-bottom-color: #31CE36 !important; }
  .quick-actions.quick-actions-success .quick-actions-header {
    background: #31CE36; }
  .quick-actions.quick-actions-success .quick-actions-item {
    color: #31CE36; }
  .quick-actions.quick-actions-danger:after {
    border-bottom-color: #F25961 !important; }
  .quick-actions.quick-actions-danger .quick-actions-header {
    background: #F25961; }
  .quick-actions.quick-actions-danger .quick-actions-item {
    color: #F25961; }

@media screen and (max-width: 991px) {
  .notif-box .notif-scroll, .messages-notif-box .message-notif-scroll, .quick-actions .quick-actions-scroll {
    max-height: calc(100vh - 200px); }

  .dropdown-user .dropdown-user-scroll {
    max-height: calc(100vh - 132px); } }
@media screen and (min-width: 991px) {
  .navbar-header .dropdown-menu {
    margin-top: 13px; }
    .navbar-header .dropdown-menu:after {
      border-bottom: 8px solid #fff;
      border-left: 8px solid transparent;
      border-right: 8px solid transparent;
      content: "";
      right: 10px;
      top: -8px;
      position: absolute;
      z-index: 1001; } }
/*     Chart Circle    */
.chart-circle {
  display: flex;
  justify-content: center; }
  .chart-circle .circles-text {
    font-size: 25px !important; }

/*     Chart JS Container    */
.chart-container {
  min-height: 300px;
  position: relative; }

/*     HTML legend    */
.html-legend {
  list-style: none;
  cursor: pointer;
  padding-left: 0;
  text-align: center;
  margin-top: 1rem; }

.html-legend li {
  display: inline-block;
  vertical-align: middle;
  padding: 0 5px;
  margin-right: 5px;
  margin-bottom: 6px;
  color: #8d9498;
  font-size: 12px; }

.html-legend li.hidden {
  text-decoration: line-through; }

.html-legend li span {
  border-radius: 15px;
  display: inline-block;
  height: 15px;
  margin-right: 10px;
  width: 15px;
  vertical-align: top; }

.jqstooltip {
  box-sizing: content-box; }

/*     Alert    */
.alert {
  border: 0px;
  position: relative;
  padding: .95rem 1.25rem;
  border-radius: 1px;
  color: inherit;
  background-color: #ffffff;
  -webkit-box-shadow: 1px 1px 14px 0px rgba(18, 38, 63, 0.26);
  -moz-box-shadow: 1px 1px 14px 0px rgba(18, 38, 63, 0.26);
  box-shadow: 1px 1px 14px 0px rgba(18, 38, 63, 0.26); }
  .alert [data-notify="icon"] {
    display: block; }
    .alert [data-notify="icon"]::before {
      line-height: 35px;
      font-size: 22px;
      display: block;
      left: 15px;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 35px;
      height: 35px;
      border-radius: 30px;
      text-align: center;
      color: #fff; }
  .alert [data-notify="title"] {
    display: block;
    color: #2b2b2b;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 5px; }
  .alert [data-notify="message"] {
    font-size: 13px;
    color: #908e8e; }
  .alert .close {
    background: rgba(255, 255, 255, 0.8);
    width: 25px;
    height: 25px;
    line-height: 25px;
    top: 12px !important;
    border-radius: 50%; }

/*    Alert States    */
.alert-black {
  border-left: 4px solid #1a2035; }
  .alert-black [data-notify="icon"]:before {
    background: #1a2035; }

.alert-primary {
  border-left: 4px solid #1572E8; }
  .alert-primary [data-notify="icon"]:before {
    background: #1572E8; }

.alert-secondary {
  border-left: 4px solid #6861CE; }
  .alert-secondary [data-notify="icon"]:before {
    background: #6861CE; }

.alert-info {
  border-left: 4px solid #48ABF7; }
  .alert-info [data-notify="icon"]:before {
    background: #48ABF7; }

.alert-success {
  border-left: 4px solid #31CE36; }
  .alert-success [data-notify="icon"]:before {
    background: #31CE36; }

.alert-warning {
  border-left: 4px solid #FFAD46; }
  .alert-warning [data-notify="icon"]:before {
    background: #FFAD46; }

.alert-danger {
  border-left: 4px solid #F25961; }
  .alert-danger [data-notify="icon"]:before {
    background: #F25961; }

/*    Button    */
.btn {
  padding: .65rem 1.4rem;
  font-size: 14px;
  opacity: 1;
  border-radius: 3px; }
  .btn:hover, .btn:focus {
    opacity: 0.9;
    transition: all .3s; }
  .btn .btn-label {
    display: inline-block; }
    .btn .btn-label i {
      font-size: 16px;
      vertical-align: middle;
      margin-right: 2px;
      margin-left: -2px;
      line-height: 0;
      margin-top: -2.5px; }
    .btn .btn-label.just-icon i {
      margin-left: 0 !important;
      margin-right: 0px !important; }

/*     Button Sizes     */
.btn-lg {
  font-size: 15px;
  border-radius: 3px;
  padding: 12.5px 27.5px;
  font-weight: 400; }
  .btn-lg .btn-label i {
    font-size: 27px;
    vertical-align: middle;
    margin-right: 2px;
    margin-left: -7px;
    line-height: 0;
    margin-top: -2.5px; }
  .btn-lg .btn-label.just-icon i {
    margin-left: 0 !important;
    margin-right: 0px !important; }

.btn-sm {
  font-size: 11px;
  padding: 7px 13px; }

.btn-xs {
  font-size: 10px;
  padding: 5px 9px; }

.btn.disabled:hover, .btn:hover:disabled {
  opacity: 0.65; }

/*      Button Icon        */
.btn-icon {
  font-size: .9375rem;
  height: 2.5125rem;
  line-height: normal;
  min-width: 2.5125rem;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: 2.5125rem; }
  .btn-icon.btn-lg {
    height: 2.75rem;
    min-width: 2.75rem;
    width: 2.75rem; }
  .btn-icon.btn-sm {
    height: 2rem;
    min-width: 2rem;
    width: 2rem; }
  .btn-icon.btn-xs {
    height: 1.6875rem;
    min-width: 1.6875rem;
    width: 1.6875rem; }

/*      Button States      */
.btn-white {
  background: #ffffff !important;
  color: #1a2035 !important; }
  .btn-white:hover, .btn-white:focus, .btn-white:disabled {
    background: #ffffff !important;
    color: #1a2035 !important; }

.btn-black {
  background: #1a2035 !important;
  color: #ffffff !important; }
  .btn-black:hover, .btn-black:focus, .btn-black:disabled {
    background: #1a2035 !important;
    color: #ffffff !important; }

.btn-primary {
  background: #1572E8 !important;
  border-color: #1572E8 !important; }
  .btn-primary:hover, .btn-primary:focus, .btn-primary:disabled {
    background: #1572E8 !important;
    border-color: #1572E8 !important; }

.btn-secondary {
  background: #6861CE !important;
  border-color: #6861CE !important; }
  .btn-secondary:hover, .btn-secondary:focus, .btn-secondary:disabled {
    background: #6861CE !important;
    border-color: #6861CE !important; }

.btn-info {
  background: #48ABF7 !important;
  border-color: #48ABF7 !important; }
  .btn-info:hover, .btn-info:focus, .btn-info:disabled {
    background: #48ABF7 !important;
    border-color: #48ABF7 !important; }

.btn-success {
  background: #31CE36 !important;
  border-color: #31CE36 !important; }
  .btn-success:hover, .btn-success:focus, .btn-success:disabled {
    background: #31CE36 !important;
    border-color: #31CE36 !important; }

.btn-warning {
  background: #FFAD46 !important;
  border-color: #FFAD46 !important;
  color: #ffffff !important; }
  .btn-warning:hover, .btn-warning:focus, .btn-warning:disabled {
    background: #FFAD46 !important;
    border-color: #FFAD46 !important;
    color: #ffffff !important; }

.btn-danger {
  background: #F25961 !important;
  border-color: #F25961 !important; }
  .btn-danger:hover, .btn-danger:focus, .btn-danger:disabled {
    background: #F25961 !important;
    border-color: #F25961 !important; }

.btn-light {
  background: #ffffff !important;
  border-color: transparent; }
  .btn-light:hover, .btn-light:focus, .btn-light:disabled {
    background: #ebecec !important;
    border-color: transparent; }

.btn-dropdown-card-header {
  padding: 0;
  background: transparent;
  color: inherit;
  font-size: 15px; }
  .btn-dropdown-card-header:after {
    display: none; }

/*      Button Border     */
.btn-border {
  background: transparent !important; }
  .btn-border:hover, .btn-border:focus {
    background: transparent !important; }
  .btn-border.btn-white {
    color: #ffffff !important;
    border: 1px solid #ffffff !important; }
  .btn-border.btn-black {
    color: #1a2035 !important;
    border: 1px solid #1a2035 !important; }
  .btn-border.btn-primary {
    color: #1572E8 !important;
    border: 1px solid #1572E8 !important; }
  .btn-border.btn-secondary {
    color: #6861CE !important;
    border: 1px solid #6861CE !important; }
  .btn-border.btn-info {
    color: #48ABF7 !important;
    border: 1px solid #48ABF7 !important; }
  .btn-border.btn-success {
    color: #31CE36 !important;
    border: 1px solid #31CE36 !important; }
  .btn-border.btn-warning {
    color: #FFAD46 !important;
    border: 1px solid #FFAD46 !important; }
  .btn-border.btn-danger {
    color: #F25961 !important;
    border: 1px solid #F25961 !important; }
  .btn-border.btn-light {
    border: 1px solid #efefef;
    background: #fff !important; }

/*      Button Rounded      */
.btn-round {
  border-radius: 100px !important; }

/*      Button Link      */
.btn-link {
  border: 0 !important;
  background: transparent !important; }
  .btn-link:hover, .btn-link:focus {
    text-decoration: underline !important;
    background: transparent !important;
    border: 0 !important; }
  .btn-link.btn-black {
    color: #1a2035 !important; }
    .btn-link.btn-black:hover {
      color: #1a2035 !important; }
  .btn-link.btn-primary {
    color: #1572E8 !important; }
    .btn-link.btn-primary:hover {
      color: #1572E8 !important; }
  .btn-link.btn-secondary {
    color: #6861CE !important; }
    .btn-link.btn-secondary:hover {
      color: #6861CE !important; }
  .btn-link.btn-info {
    color: #48ABF7 !important; }
    .btn-link.btn-info:hover {
      color: #48ABF7 !important; }
  .btn-link.btn-success {
    color: #31CE36 !important; }
    .btn-link.btn-success:hover {
      color: #31CE36 !important; }
  .btn-link.btn-warning {
    color: #FFAD46 !important; }
    .btn-link.btn-warning:hover {
      color: #FFAD46 !important; }
  .btn-link.btn-danger {
    color: #F25961 !important; }
    .btn-link.btn-danger:hover {
      color: #F25961 !important; }

.toggle-on.btn {
  color: #ffffff !important; }

.toggle-handle {
  background: #ffffff !important; }
  .toggle-handle:hover {
    background: #ffffff !important; }

.btn-round .toggle-handle {
  border-radius: 50px; }

.btn-rounded {
  border-radius: 60px !important; }

.btn-full {
  width: 100%; }

.btn-no-radius {
  border-radius: 0px; }

/*     Nav Pill     */
.nav-pills > li:first-child > .nav-link {
  border-radius: 4px 0 0 4px !important; }
.nav-pills > li:last-child > .nav-link {
  border-radius: 0 4px 4px 0 !important; }

.nav-link.disabled {
  color: #6c757d !important; }

.nav-pills .nav-link {
  padding: 10px 20px; }
.nav-pills > li > .nav-link {
  margin-left: -1px;
  border-radius: 0 !important;
  margin-top: 5px;
  margin-bottom: 5px;
  border: 1px solid #1572E8;
  color: #585c5d; }
  .nav-pills > li > .nav-link.active {
    background: #1572E8; }
  .nav-pills > li > .nav-link:hover {
    background: rgba(222, 222, 222, 0.4); }
.nav-pills.nav-pills-no-bd li {
  margin-left: 15px !important; }
  .nav-pills.nav-pills-no-bd li .nav-link {
    border: 0px !important;
    border-radius: 50px !important;
    background: rgba(222, 222, 222, 0.4); }
    .nav-pills.nav-pills-no-bd li .nav-link.active {
      border-radius: 50px !important; }
  .nav-pills.nav-pills-no-bd li:first-child {
    margin-left: 0px !important; }
.nav-pills.nav-pills-no-bd.nav-pills-icons .nav-link, .nav-pills.nav-pills-no-bd.nav-pills-icons .nav-link.active {
  border-radius: 5px !important; }
.nav-pills.flex-column .nav-link {
  border-radius: 0 !important;
  border: 1px solid #1572E8;
  color: #585c5d;
  margin-top: -1px;
  text-align: center;
  word-wrap: normal;
  padding: 10px 0; }
  .nav-pills.flex-column .nav-link:hover {
    background: rgba(222, 222, 222, 0.4); }
  .nav-pills.flex-column .nav-link.active {
    background: #1572E8; }
  .nav-pills.flex-column .nav-link:first-child {
    border-radius: 4px 4px 0 0 !important; }
  .nav-pills.flex-column .nav-link:last-child {
    border-radius: 0 0 4px 4px !important; }
.nav-pills.flex-column.nav-pills-no-bd .nav-link {
  border: 0px !important;
  border-radius: 50px !important;
  background: rgba(222, 222, 222, 0.4);
  margin-top: 5px;
  margin-bottom: 5px; }
  .nav-pills.flex-column.nav-pills-no-bd .nav-link.active {
    border-radius: 50px !important; }
.nav-pills.flex-column.nav-pills-icons .nav-link, .nav-pills.flex-column.nav-pills-icons .nav-link.active {
  border-radius: 5px !important; }
.nav-pills.nav-pills-icons .nav-link, .nav-pills.nav-pills-icons .nav-link.active {
  border-radius: 5px !important;
  padding-top: 12px;
  padding-bottom: 12px; }
.nav-pills.nav-pills-icons i {
  display: block;
  text-align: center;
  font-size: 2em;
  line-height: 50px; }
.nav-pills.nav-black .nav-link, .nav-pills.nav-primary .nav-link, .nav-pills.nav-secondary .nav-link, .nav-pills.nav-info .nav-link, .nav-pills.nav-warning .nav-link, .nav-pills.nav-success .nav-link, .nav-pills.nav-danger .nav-link {
  border: 1px solid #eeeeee; }
.nav-pills.nav-black .nav-link.active, .nav-pills.nav-primary .nav-link.active, .nav-pills.nav-secondary .nav-link.active, .nav-pills.nav-info .nav-link.active, .nav-pills.nav-warning .nav-link.active, .nav-pills.nav-success .nav-link.active, .nav-pills.nav-danger .nav-link.active {
  color: #ffffff !important; }
.nav-pills.nav-black .nav-link.active {
  background: #1a2035;
  border: 1px solid #1a2035; }
.nav-pills.nav-primary .nav-link.active {
  background: #1572E8;
  border: 1px solid #1572E8; }
.nav-pills.nav-secondary .nav-link.active {
  background: #6861CE;
  border: 1px solid #6861CE; }
.nav-pills.nav-info .nav-link.active {
  background: #48ABF7;
  border: 1px solid #48ABF7; }
.nav-pills.nav-success .nav-link.active {
  background: #31CE36;
  border: 1px solid #31CE36; }
.nav-pills.nav-warning .nav-link.active {
  background: #FFAD46;
  border: 1px solid #FFAD46; }
.nav-pills.nav-danger .nav-link.active {
  background: #F25961;
  border: 1px solid #F25961; }

/* Nav Line */
.row-nav-line {
  margin-left: -20px;
  margin-right: -20px; }

.nav.nav-line .nav-link, .nav.nav-simple .nav-link {
  padding: 18px 0 !important;
  margin-right: 40px;
  color: #6B6D7E;
  border-width: 0px;
  font-size: 14px;
  font-weight: 600; }
  .nav.nav-line .nav-link:hover, .nav.nav-line .nav-link:focus, .nav.nav-simple .nav-link:hover, .nav.nav-simple .nav-link:focus {
    color: #1572E8;
    border-width: 0px; }
  .nav.nav-line .nav-link.active, .nav.nav-simple .nav-link.active {
    border-width: 0;
    background-color: transparent;
    color: #1572E8;
    border-radius: 0px; }
.nav.nav-simple.nav-color-black .nav-link:hover, .nav.nav-simple.nav-color-black .nav-link:focus {
  color: #1a2035; }
.nav.nav-simple.nav-color-black .nav-link.active {
  color: #1a2035; }
.nav.nav-simple.nav-color-primary .nav-link:hover, .nav.nav-simple.nav-color-primary .nav-link:focus {
  color: #1572E8; }
.nav.nav-simple.nav-color-primary .nav-link.active {
  color: #1572E8; }
.nav.nav-simple.nav-color-secondary .nav-link:hover, .nav.nav-simple.nav-color-secondary .nav-link:focus {
  color: #6861CE; }
.nav.nav-simple.nav-color-secondary .nav-link.active {
  color: #6861CE; }
.nav.nav-simple.nav-color-info .nav-link:hover, .nav.nav-simple.nav-color-info .nav-link:focus {
  color: #48ABF7; }
.nav.nav-simple.nav-color-info .nav-link.active {
  color: #48ABF7; }
.nav.nav-simple.nav-color-success .nav-link:hover, .nav.nav-simple.nav-color-success .nav-link:focus {
  color: #31CE36; }
.nav.nav-simple.nav-color-success .nav-link.active {
  color: #31CE36; }
.nav.nav-simple.nav-color-danger .nav-link:hover, .nav.nav-simple.nav-color-danger .nav-link:focus {
  color: #F25961; }
.nav.nav-simple.nav-color-danger .nav-link.active {
  color: #F25961; }
.nav.nav-simple.nav-color-warning .nav-link:hover, .nav.nav-simple.nav-color-warning .nav-link:focus {
  color: #FFAD46; }
.nav.nav-simple.nav-color-warning .nav-link.active {
  color: #FFAD46; }
.nav.nav-simple.nav-color-light .nav-link:hover, .nav.nav-simple.nav-color-light .nav-link:focus {
  color: #ffffff; }
.nav.nav-simple.nav-color-light .nav-link.active {
  color: #ffffff; }
.nav.nav-simple.nav-color-light .nav-link {
  color: #f1f1f1; }
.nav.nav-line .nav-link.active {
  border-bottom: 3px solid #1572E8; }
.nav.nav-line.nav-color-black .nav-link:hover, .nav.nav-line.nav-color-black .nav-link:focus {
  color: #1a2035; }
.nav.nav-line.nav-color-black .nav-link.active {
  color: #1a2035; }
.nav.nav-line.nav-color-black .nav-link.active {
  border-color: #1a2035; }
.nav.nav-line.nav-color-primary .nav-link:hover, .nav.nav-line.nav-color-primary .nav-link:focus {
  color: #1572E8; }
.nav.nav-line.nav-color-primary .nav-link.active {
  color: #1572E8; }
.nav.nav-line.nav-color-primary .nav-link.active {
  border-color: #1572E8; }
.nav.nav-line.nav-color-secondary .nav-link:hover, .nav.nav-line.nav-color-secondary .nav-link:focus {
  color: #6861CE; }
.nav.nav-line.nav-color-secondary .nav-link.active {
  color: #6861CE; }
.nav.nav-line.nav-color-secondary .nav-link.active {
  border-color: #6861CE; }
.nav.nav-line.nav-color-info .nav-link:hover, .nav.nav-line.nav-color-info .nav-link:focus {
  color: #48ABF7; }
.nav.nav-line.nav-color-info .nav-link.active {
  color: #48ABF7; }
.nav.nav-line.nav-color-info .nav-link.active {
  border-color: #48ABF7; }
.nav.nav-line.nav-color-success .nav-link:hover, .nav.nav-line.nav-color-success .nav-link:focus {
  color: #31CE36; }
.nav.nav-line.nav-color-success .nav-link.active {
  color: #31CE36; }
.nav.nav-line.nav-color-success .nav-link.active {
  border-color: #31CE36; }
.nav.nav-line.nav-color-danger .nav-link:hover, .nav.nav-line.nav-color-danger .nav-link:focus {
  color: #F25961; }
.nav.nav-line.nav-color-danger .nav-link.active {
  color: #F25961; }
.nav.nav-line.nav-color-danger .nav-link.active {
  border-color: #F25961; }
.nav.nav-line.nav-color-warning .nav-link:hover, .nav.nav-line.nav-color-warning .nav-link:focus {
  color: #FFAD46; }
.nav.nav-line.nav-color-warning .nav-link.active {
  color: #FFAD46; }
.nav.nav-line.nav-color-warning .nav-link.active {
  border-color: #FFAD46; }
.nav.nav-line.nav-color-light .nav-link:hover, .nav.nav-line.nav-color-light .nav-link:focus {
  color: #ffffff; }
.nav.nav-line.nav-color-light .nav-link.active {
  color: #ffffff; }
.nav.nav-line.nav-color-light .nav-link.active {
  border-color: #ffffff; }
.nav.nav-line.nav-color-light .nav-link {
  color: #f1f1f1; }

/* Size Nav */
.nav-sm .nav-link {
  font-size: 11px !important;
  padding: 8px 16px !important; }

/*     	Popover     */
.popover {
  max-width: 240px;
  line-height: 1.7;
  border: 0;
  box-shadow: 0px 0px 20px 1px rgba(69, 65, 78, 0.2); }
  .popover .popover-header {
    background: transparent;
    font-size: 14px;
    border-bottom: 0px;
    text-transform: capitalize;
    margin-top: 5px;
    color: #aaaaaa;
    font-weight: 400; }
  .popover .popover-body {
    margin-bottom: 5px; }
    .popover .popover-body p {
      font-size: 13px;
      margin-bottom: 1rem; }
  .popover.bs-popover-top .arrow:before, .popover.bs-popover-bottom .arrow:before, .popover.bs-popover-left .arrow:before, .popover.bs-popover-right .arrow:before {
    border: transparent; }

.popover.bs-popover-auto[x-placement^=right], .popover.bs-popover-right {
  margin-left: 10px; }

.popover.bs-popover-auto[x-placement^=left], .popover.bs-popover-left {
  margin-right: 10px; }

.popover.bs-popover-auto[x-placement^=top], .popover.bs-popover-top {
  margin-bottom: 10px; }

.popover.bs-popover-auto[x-placement^=bottom], .popover.bs-popover-bottom {
  margin-top: 10px; }

/*     	Progress     */
.progress {
  border-radius: 100px;
  height: 14px; }
  .progress .progress-bar {
    border-radius: 100px; }
  .progress.progress-sm {
    height: 8px; }
  .progress.progress-lg {
    height: 20px; }

/*     Pagination     */
.pagination > li > a, .pagination > li:first-child > a, .pagination > li:last-child > a, .pagination > li > span, .pagination > li:first-child > span, .pagination > li:last-child > span {
  border-radius: 100px !important;
  margin: 0 2px;
  color: #777777;
  border-color: #ddd; }
.pagination.pg-black > li.active > a, .pagination.pg-black > li.active:first-child > a, .pagination.pg-black > li.active:last-child > a, .pagination.pg-black > li.active > span, .pagination.pg-black > li.active:first-child > span, .pagination.pg-black > li.active:last-child > span {
  background: #1a2035;
  border-color: #1a2035;
  color: #ffffff; }
.pagination.pg-primary > li.active > a, .pagination.pg-primary > li.active:first-child > a, .pagination.pg-primary > li.active:last-child > a, .pagination.pg-primary > li.active > span, .pagination.pg-primary > li.active:first-child > span, .pagination.pg-primary > li.active:last-child > span {
  background: #1572E8;
  border-color: #1572E8;
  color: #ffffff; }
.pagination.pg-secondary > li.active > a, .pagination.pg-secondary > li.active:first-child > a, .pagination.pg-secondary > li.active:last-child > a, .pagination.pg-secondary > li.active > span, .pagination.pg-secondary > li.active:first-child > span, .pagination.pg-secondary > li.active:last-child > span {
  background: #6861CE;
  border-color: #6861CE;
  color: #ffffff; }
.pagination.pg-info > li.active > a, .pagination.pg-info > li.active:first-child > a, .pagination.pg-info > li.active:last-child > a, .pagination.pg-info > li.active > span, .pagination.pg-info > li.active:first-child > span, .pagination.pg-info > li.active:last-child > span {
  background: #48ABF7;
  border-color: #48ABF7;
  color: #ffffff; }
.pagination.pg-success > li.active > a, .pagination.pg-success > li.active:first-child > a, .pagination.pg-success > li.active:last-child > a, .pagination.pg-success > li.active > span, .pagination.pg-success > li.active:first-child > span, .pagination.pg-success > li.active:last-child > span {
  background: #31CE36;
  border-color: #31CE36;
  color: #ffffff; }
.pagination.pg-warning > li.active > a, .pagination.pg-warning > li.active:first-child > a, .pagination.pg-warning > li.active:last-child > a, .pagination.pg-warning > li.active > span, .pagination.pg-warning > li.active:first-child > span, .pagination.pg-warning > li.active:last-child > span {
  background: #FFAD46;
  border-color: #FFAD46;
  color: #ffffff; }
.pagination.pg-danger > li.active > a, .pagination.pg-danger > li.active:first-child > a, .pagination.pg-danger > li.active:last-child > a, .pagination.pg-danger > li.active > span, .pagination.pg-danger > li.active:first-child > span, .pagination.pg-danger > li.active:last-child > span {
  background: #F25961;
  border-color: #F25961;
  color: #ffffff; }

/*     Slider     */
.slider-black .ui-slider-range {
  background: #1a2035; }

.slider-primary .ui-slider-range {
  background: #1572E8; }

.slider-secondary .ui-slider-range {
  background: #6861CE; }

.slider-info .ui-slider-range {
  background: #48ABF7; }

.slider-success .ui-slider-range {
  background: #31CE36; }

.slider-warning .ui-slider-range {
  background: #FFAD46; }

.slider-danger .ui-slider-range {
  background: #F25961; }

/*     	Modal     */
.modal .bg-black .modal-title, .modal .bg-primary .modal-title, .modal .bg-secondary .modal-title, .modal .bg-info .modal-title, .modal .bg-success .modal-title, .modal .bg-warning .modal-title, .modal .bg-danger .modal-title {
  color: #ffffff !important; }

.modal-content {
  border-radius: .4rem !important;
  border: 0 !important; }

.rating > label {
  display: inline;
  color: #e9eaeb !important;
  line-height: 1;
  float: right;
  cursor: pointer; }
  .rating > label:hover {
    color: #FFC600 !important;
    opacity: 0.5; }
  .rating > label span {
    font-size: 18px; }
.rating input[type="radio"], .rating input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  z-index: -1; }
  .rating input[type="radio"]:checked ~ label, .rating input[type="checkbox"]:checked ~ label {
    color: #FFC600 !important; }

.activity-feed {
  padding: 15px;
  list-style: none; }
  .activity-feed .feed-item {
    position: relative;
    padding-bottom: 20px;
    padding-left: 30px;
    border-left: 2px solid #e4e8eb; }
    .activity-feed .feed-item:last-child {
      border-color: transparent; }
    .activity-feed .feed-item::after {
      content: "";
      display: block;
      position: absolute;
      top: 0;
      left: -7px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #177dff; }

.feed-item-black::after {
  background: #1a2035 !important; }

.feed-item-primary::after {
  background: #1572E8 !important; }

.feed-item-secondary::after {
  background: #6861CE !important; }

.feed-item-success::after {
  background: #31CE36 !important; }

.feed-item-danger::after {
  background: #F25961 !important; }

.feed-item-info::after {
  background: #48ABF7 !important; }

.feed-item-warning::after {
  background: #FFAD46 !important; }

.activity-feed .feed-item .date {
  display: block;
  position: relative;
  top: -5px;
  color: #8c96a3;
  text-transform: uppercase;
  font-size: 13px; }
.activity-feed .feed-item .text {
  position: relative;
  top: -3px; }

/*      Timeline     */
.timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative; }
  .timeline:before {
    top: 0;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 3px;
    background-color: #eeeeee;
    left: 50%;
    margin-left: -1.5px; }
  .timeline > li {
    margin-bottom: 20px;
    position: relative; }
    .timeline > li:before {
      content: " ";
      display: table; }
    .timeline > li:after {
      content: " ";
      display: table;
      clear: both; }
    .timeline > li:before {
      content: " ";
      display: table; }
    .timeline > li:after {
      content: " ";
      display: table;
      clear: both; }
    .timeline > li > .timeline-panel {
      width: 50%;
      float: left;
      border: 1px solid #eeeeee;
      background: #ffffff;
      border-radius: 3px;
      padding: 20px;
      position: relative;
      -webkit-box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06);
      -moz-box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06);
      box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06); }
    .timeline > li.timeline-inverted + li:not(.timeline-inverted) {
      margin-top: -60px; }
    .timeline > li:not(.timeline-inverted) {
      padding-right: 90px; }
      .timeline > li:not(.timeline-inverted) + li.timeline-inverted {
        margin-top: -60px; }
    .timeline > li.timeline-inverted {
      padding-left: 90px; }
      .timeline > li.timeline-inverted > .timeline-panel {
        float: right; }
        .timeline > li.timeline-inverted > .timeline-panel:before {
          border-left-width: 0;
          border-right-width: 15px;
          left: -15px;
          right: auto; }
        .timeline > li.timeline-inverted > .timeline-panel:after {
          border-left-width: 0;
          border-right-width: 14px;
          left: -14px;
          right: auto; }
    .timeline > li > .timeline-panel:before {
      position: absolute;
      top: 26px;
      right: -15px;
      display: inline-block;
      border-top: 15px solid transparent;
      border-left: 15px solid #eeeeee;
      border-right: 0 solid #eeeeee;
      border-bottom: 15px solid transparent;
      content: " "; }
    .timeline > li > .timeline-panel:after {
      position: absolute;
      top: 27px;
      right: -14px;
      display: inline-block;
      border-top: 14px solid transparent;
      border-left: 14px solid #ffffff;
      border-right: 0 solid #ffffff;
      border-bottom: 14px solid transparent;
      content: " "; }
    .timeline > li > .timeline-badge {
      color: #ffffff;
      width: 50px;
      height: 50px;
      line-height: 50px;
      font-size: 1.8em;
      text-align: center;
      position: absolute;
      top: 16px;
      left: 50%;
      margin-left: -25px;
      background-color: #999999;
      z-index: 100;
      border-top-right-radius: 50%;
      border-top-left-radius: 50%;
      border-bottom-right-radius: 50%;
      border-bottom-left-radius: 50%; }

.timeline-badge.black {
  background-color: #1a2035 !important; }
.timeline-badge.primary {
  background-color: #1572E8 !important; }
.timeline-badge.secondary {
  background-color: #6861CE !important; }
.timeline-badge.success {
  background-color: #31CE36 !important; }
.timeline-badge.warning {
  background-color: #FFAD46 !important; }
.timeline-badge.danger {
  background-color: #F25961 !important; }
.timeline-badge.info {
  background-color: #48ABF7 !important; }

.timeline-title {
  font-size: 17px;
  margin-top: 0;
  color: inherit;
  font-weight: 400; }

.timeline-heading i {
  font-size: 22px;
  display: inline-block;
  vertical-align: middle;
  margin-right: 5px; }

.timeline-body > p, .timeline-body > ul {
  margin-bottom: 0; }
.timeline-body > p + p {
  margin-top: 5px; }

/*      Google Maps      */
.full-screen-maps {
  height: 100vh !important; }

/*      jQVMap     */
.vmap {
  width: 100%;
  min-height: 265px; }
  .vmap > svg {
    margin: auto;
    display: flex; }
    .vmap > svg > g {
      transition: all ease-in-out .2s; }

.jqvmap-label, .jqvmap-pin {
  pointer-events: none; }

.jqvmap-label {
  position: absolute;
  display: none;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background: #292929;
  color: #ffffff;
  font-size: smaller;
  padding: 3px; }

.jqvmap-zoomin, .jqvmap-zoomout {
  position: absolute;
  left: 10px;
  border-radius: 13px;
  background: #35cd3a;
  padding: 6px 7px;
  color: #ffffff;
  cursor: pointer;
  line-height: 10px;
  text-align: center;
  font-size: 14px; }

.jqvmap-zoomin {
  top: 15px; }

.jqvmap-zoomout {
  top: 45px; }

.jqvmap-region {
  cursor: pointer; }

.jqvmap-ajax_response {
  width: 100%;
  height: 500px; }

/* 		Wizard 		*/
.wizard-container {
  margin: 0 auto;
  border-radius: 0px;
  background-color: #ffffff;
  margin-bottom: 30px;
  -webkit-box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06);
  -moz-box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06);
  box-shadow: 0px 1px 20px 1px rgba(69, 65, 78, 0.06);
  border: 1px solid #eee;
  padding: 10px 0; }
  .wizard-container.wizard-round {
    border-radius: 5px; }
  .wizard-container .wizard-header {
    padding: 25px 15px;
    background-color: transparent; }
    .wizard-container .wizard-header .wizard-title {
      margin: 0;
      color: #2A2F5B;
      font-size: 25px;
      font-weight: 300;
      line-height: 1.7; }
    .wizard-container .wizard-header small {
      font-size: 15px;
      padding: 8px 0;
      display: inline-block;
      font-weight: 300; }
    .wizard-container .wizard-header b {
      font-weight: 400; }
  .wizard-container .wizard-body {
    padding: 15px 15px 10px 15px; }
    .wizard-container .wizard-body .info-text {
      padding: 15px 10px 10px;
      text-align: center;
      margin-top: 10px;
      font-size: 18px;
      font-weight: 300; }
    .wizard-container .wizard-body .tab-content {
      padding: 25px 15px; }
  .wizard-container .wizard-action {
    padding: 30px;
    background-color: transparent;
    line-height: 30px;
    font-size: 14px; }
    .wizard-container .wizard-action .btn {
      min-width: 140px; }
  .wizard-container .wizard-menu {
    width: 100%;
    position: relative; }
    .wizard-container .wizard-menu li {
      background: #f5f5f5; }
      .wizard-container .wizard-menu li a {
        padding: 11px;
        text-align: center;
        border-radius: 0 !important;
        background: transparent;
        border: 0 !important;
        color: #555 !important;
        font-weight: 400;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        border-left: 0 !important;
        border-right: 0 !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important; }
        .wizard-container .wizard-menu li a.active {
          background: transparent !important;
          color: #555 !important; }
        .wizard-container .wizard-menu li a:hover {
          background: transparent !important; }
        .wizard-container .wizard-menu li a i {
          font-size: 22px;
          display: inline-block;
          line-height: normal;
          vertical-align: bottom;
          padding-right: 5px; }
    .wizard-container .wizard-menu .moving-tab {
      position: absolute;
      text-align: center;
      padding: 14px;
      font-size: 11px;
      text-transform: uppercase;
      -webkit-font-smoothing: subpixel-antialiased;
      background-color: #1a2035;
      top: -3px;
      left: 0px;
      border-radius: 3px;
      color: #ffffff;
      cursor: pointer;
      font-weight: 400;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 1px 15px 1px rgba(39, 39, 39, 0.1); }
      .wizard-container .wizard-menu .moving-tab i {
        font-size: 22px;
        display: inline-block;
        line-height: normal;
        vertical-align: bottom;
        padding-right: 5px; }
    .wizard-container .wizard-menu.nav-black li a {
      color: #1a2035 !important; }
    .wizard-container .wizard-menu.nav-black .moving-tab {
      background-color: #1a2035; }
    .wizard-container .wizard-menu.nav-primary li a {
      color: #1572E8 !important; }
    .wizard-container .wizard-menu.nav-primary .moving-tab {
      background-color: #1572E8; }
    .wizard-container .wizard-menu.nav-secondary li a {
      color: #6861CE !important; }
    .wizard-container .wizard-menu.nav-secondary .moving-tab {
      background-color: #6861CE; }
    .wizard-container .wizard-menu.nav-info li a {
      color: #48ABF7 !important; }
    .wizard-container .wizard-menu.nav-info .moving-tab {
      background-color: #48ABF7; }
    .wizard-container .wizard-menu.nav-success li a {
      color: #31CE36 !important; }
    .wizard-container .wizard-menu.nav-success .moving-tab {
      background-color: #31CE36; }
    .wizard-container .wizard-menu.nav-danger li a {
      color: #F25961 !important; }
    .wizard-container .wizard-menu.nav-danger .moving-tab {
      background-color: #F25961; }
    .wizard-container .wizard-menu.nav-warning li a {
      color: #FFAD46 !important; }
    .wizard-container .wizard-menu.nav-warning .moving-tab {
      background-color: #FFAD46; }

/*     Invoices	    */
.card-invoice .invoice-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px; }
  .card-invoice .invoice-header .invoice-title {
    font-size: 27px;
    font-weight: 400; }
  .card-invoice .invoice-header .invoice-logo {
    width: 150px;
    display: flex;
    align-items: center; }
    .card-invoice .invoice-header .invoice-logo img {
      width: 100%; }
.card-invoice .sub {
  font-size: 14px;
  margin-bottom: 8px;
  font-weight: 600; }
.card-invoice .info-invoice {
  padding-top: 15px;
  padding-bottom: 15px; }
  .card-invoice .info-invoice p {
    font-size: 13px; }
.card-invoice .invoice-desc {
  text-align: right;
  font-size: 13px; }
.card-invoice .invoice-detail {
  width: 100%;
  display: block; }
  .card-invoice .invoice-detail .invoice-top .title {
    font-size: 20px; }
.card-invoice .transfer-to .sub {
  font-size: 14px;
  margin-bottom: 8px;
  font-weight: 600; }
.card-invoice .transfer-to .account-transfer > div span:first-child {
  font-weight: 600;
  font-size: 13px; }
.card-invoice .transfer-to .account-transfer > div span:last-child {
  font-size: 13px;
  float: right; }
.card-invoice .transfer-total {
  text-align: right;
  display: flex;
  flex-direction: column;
  justify-content: center; }
  .card-invoice .transfer-total .sub {
    font-size: 14px;
    margin-bottom: 8px;
    font-weight: 600; }
  .card-invoice .transfer-total .price {
    font-size: 28px;
    color: #1572E8;
    padding: 7px 0;
    font-weight: 600; }
  .card-invoice .transfer-total span {
    font-weight: 600;
    font-size: 13px; }
.card-invoice .card-body {
  padding: 0;
  border: 0px !important;
  width: 75%;
  margin: auto; }
.card-invoice .card-header {
  padding: 50px 0px 20px;
  border: 0px !important;
  width: 75%;
  margin: auto; }
.card-invoice .card-footer {
  padding: 5px 0 50px;
  border: 0px !important;
  width: 75%;
  margin: auto; }

.list-group .list-group-header {
  font-size: 12px;
  font-weight: 600;
  padding: .75rem 1rem; }
.list-group .list-group-item {
  display: flex;
  align-items: stretch;
  border-width: 1px 0;
  border-color: #ebecec; }
.list-group .list-group-item-figure {
  align-self: start;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  color: #a9acb0; }
.list-group .list-group-item-body {
  flex: 1;
  min-width: 0;
  align-self: center;
  font-size: .875rem; }
.list-group .list-group-item-text {
  margin-bottom: 0;
  line-height: 1.25rem;
  color: #686f76; }

.list-group-file-item .list-group-item {
  padding: 0px; }
.list-group-file-item .list-group-item-figure {
  padding: .75rem 1rem; }
.list-group-file-item .list-group-item-body {
  padding: .75rem 0; }

.list-group-bordered .list-group-item {
  border: 1px solid #e3ebf6; }
  .list-group-bordered .list-group-item.active {
    background: #1572E8;
    border-color: #1572E8; }

.list-group-lg .list-group-item {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem; }

.selectgroup {
  display: -ms-inline-flexbox;
  display: inline-flex; }

.selectgroup-item {
  -ms-flex-positive: 1;
  flex-grow: 1;
  position: relative;
  font-weight: 400 !important; }
  .selectgroup-item + .selectgroup-item {
    margin-left: -1px; }
  .selectgroup-item:not(:first-child) .selectgroup-button {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0; }
  .selectgroup-item:not(:last-child) .selectgroup-button {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0; }

.selectgroup-input {
  opacity: 0;
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0; }

.selectgroup-button {
  display: block;
  border: 1px solid rgba(0, 40, 100, 0.12);
  text-align: center;
  padding: 0.375rem 1rem;
  position: relative;
  cursor: pointer;
  border-radius: 3px;
  color: #9aa0ac;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  font-size: 14px;
  line-height: 1.5rem;
  min-width: 2.375rem; }

.selectgroup-button-icon {
  padding-left: .5rem;
  padding-right: .5rem;
  font-size: 1rem; }

.selectgroup-input:checked + .selectgroup-button {
  border-color: #1572E8;
  z-index: 1;
  color: #1572E8;
  background: rgba(21, 114, 232, 0.15); }
.selectgroup-input:focus + .selectgroup-button {
  border-color: #1572E8;
  z-index: 2;
  color: #1572E8;
  box-shadow: 0 0 0 2px rgba(21, 114, 232, 0.25); }

.selectgroup-pills {
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -ms-flex-align: start;
  align-items: flex-start; }
  .selectgroup-pills .selectgroup-item {
    margin-right: .5rem;
    -ms-flex-positive: 0;
    flex-grow: 0; }
  .selectgroup-pills .selectgroup-button {
    border-radius: 50px !important; }

.selectgroup.selectgroup-primary .selectgroup-input:checked + .selectgroup-button {
  border-color: #1572E8;
  color: #1572E8;
  background: rgba(21, 114, 232, 0.15); }
.selectgroup.selectgroup-primary .selectgroup-input:focus + .selectgroup-button {
  border-color: #1572E8;
  color: #1572E8;
  box-shadow: 0 0 0 2px rgba(21, 114, 232, 0.25); }
.selectgroup.selectgroup-secondary .selectgroup-input:checked + .selectgroup-button {
  border-color: #6861CE;
  color: #6861CE;
  background: rgba(104, 97, 206, 0.15); }
.selectgroup.selectgroup-secondary .selectgroup-input:focus + .selectgroup-button {
  border-color: #6861CE;
  color: #6861CE;
  box-shadow: 0 0 0 2px rgba(104, 97, 206, 0.25); }
.selectgroup.selectgroup-info .selectgroup-input:checked + .selectgroup-button {
  border-color: #48ABF7;
  color: #48ABF7;
  background: rgba(72, 171, 247, 0.15); }
.selectgroup.selectgroup-info .selectgroup-input:focus + .selectgroup-button {
  border-color: #48ABF7;
  color: #48ABF7;
  box-shadow: 0 0 0 2px rgba(72, 171, 247, 0.25); }
.selectgroup.selectgroup-success .selectgroup-input:checked + .selectgroup-button {
  border-color: #31CE36;
  color: #31CE36;
  background: rgba(49, 206, 54, 0.15); }
.selectgroup.selectgroup-success .selectgroup-input:focus + .selectgroup-button {
  border-color: #31CE36;
  color: #31CE36;
  box-shadow: 0 0 0 2px rgba(49, 206, 54, 0.25); }
.selectgroup.selectgroup-warning .selectgroup-input:checked + .selectgroup-button {
  border-color: #FFAD46;
  color: #FFAD46;
  background: rgba(255, 173, 70, 0.15); }
.selectgroup.selectgroup-warning .selectgroup-input:focus + .selectgroup-button {
  border-color: #FFAD46;
  color: #FFAD46;
  box-shadow: 0 0 0 2px rgba(255, 173, 70, 0.25); }
.selectgroup.selectgroup-danger .selectgroup-input:checked + .selectgroup-button {
  border-color: #F25961;
  color: #F25961;
  background: rgba(242, 89, 97, 0.15); }
.selectgroup.selectgroup-danger .selectgroup-input:focus + .selectgroup-button {
  border-color: #F25961;
  color: #F25961;
  box-shadow: 0 0 0 2px rgba(242, 89, 97, 0.25); }

.colorinput {
  margin: 0;
  position: relative;
  cursor: pointer; }

.colorinput-input {
  position: absolute;
  z-index: -1;
  opacity: 0; }

.colorinput-color {
  display: inline-block;
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 3px;
  border: 1px solid rgba(0, 40, 100, 0.12);
  color: #fff;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
  .colorinput-color:before {
    content: '';
    opacity: 0;
    position: absolute;
    top: .25rem;
    left: .25rem;
    height: 1.25rem;
    width: 1.25rem;
    transition: .3s opacity;
    background: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E") no-repeat center center/50% 50%; }

.colorinput-input:checked ~ .colorinput-color:before {
  opacity: 1; }
.colorinput-input:focus ~ .colorinput-color {
  border-color: #467fcf;
  box-shadow: 0 0 0 2px rgba(70, 127, 207, 0.25); }

.imagecheck {
  margin: 0;
  position: relative;
  cursor: pointer; }

.imagecheck-input {
  position: absolute;
  z-index: -1;
  opacity: 0; }

.imagecheck-figure {
  border: 1px solid rgba(0, 40, 100, 0.12);
  border-radius: 3px;
  margin: 0;
  position: relative; }

.imagecheck-input:focus ~ .imagecheck-figure {
  border-color: #1572E8;
  box-shadow: 0 0 0 2px rgba(70, 127, 207, 0.25); }
.imagecheck-input:checked ~ .imagecheck-figure {
  border-color: rgba(0, 40, 100, 0.24); }

.imagecheck-figure:before {
  content: '';
  position: absolute;
  top: .25rem;
  left: .25rem;
  display: block;
  width: 1rem;
  height: 1rem;
  pointer-events: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background: #1572E8 url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E") no-repeat center center/50% 50%;
  color: #fff;
  z-index: 1;
  border-radius: 3px;
  opacity: 0;
  transition: .3s opacity; }

.imagecheck-input:checked ~ .imagecheck-figure:before {
  opacity: 1; }

.imagecheck-image {
  max-width: 100%;
  opacity: .64;
  transition: .3s opacity; }
  .imagecheck-image:first-child {
    border-top-left-radius: 2px;
    border-top-right-radius: 2px; }
  .imagecheck-image:last-child {
    border-bottom-left-radius: 2px;
    border-bottom-right-radius: 2px; }

.imagecheck:hover .imagecheck-image {
  opacity: 1; }

.imagecheck-input:focus ~ .imagecheck-figure .imagecheck-image, .imagecheck-input:checked ~ .imagecheck-figure .imagecheck-image {
  opacity: 1; }

.imagecheck-caption {
  text-align: center;
  padding: .25rem .25rem;
  color: #9aa0ac;
  font-size: 0.875rem;
  transition: .3s color; }

.imagecheck:hover .imagecheck-caption {
  color: #495057; }

.imagecheck-input:focus ~ .imagecheck-figure .imagecheck-caption, .imagecheck-input:checked ~ .imagecheck-figure .imagecheck-caption {
  color: #495057; }

/*     	Messages Tab    */
.tab-chat {
  position: relative; }

.messages-contact {
  position: absolute;
  left: 0;
  width: 100%;
  transition: left .3s ease; }

.messages-contact .contact-list .user a {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 11px 10px;
  border-radius: 5px; }
  .messages-contact .contact-list .user a:hover {
    text-decoration: none;
    background: rgba(0, 0, 0, 0.05); }
  .messages-contact .contact-list .user a .user-data, .messages-contact .contact-list .user a .user-data2 {
    margin-left: 20px;
    display: flex;
    flex-direction: column; }
    .messages-contact .contact-list .user a .user-data .name, .messages-contact .contact-list .user a .user-data2 .name {
      color: #2A2F5B;
      font-size: 13px;
      margin-bottom: 3px;
      font-weight: 600; }
    .messages-contact .contact-list .user a .user-data .message, .messages-contact .contact-list .user a .user-data2 .message {
      color: #aaa; }
    .messages-contact .contact-list .user a .user-data .status, .messages-contact .contact-list .user a .user-data2 .status {
      color: #979797; }

.messages-wrapper {
  position: absolute;
  left: calc(100% + 40px);
  transition: left .3s ease; }

.messages-wrapper .messages-title {
  width: 100%;
  display: inline-block;
  border-bottom: 1px solid #eee;
  margin-bottom: 15px; }
  .messages-wrapper .messages-title .user {
    width: calc(100% - 40px);
    float: right;
    text-align: right;
    padding: 10px 0; }
    .messages-wrapper .messages-title .user .name {
      display: inline-block;
      font-size: 13px;
      font-weight: 400;
      margin-bottom: 4px; }
    .messages-wrapper .messages-title .user .last-active {
      display: block;
      font-size: 10px; }
  .messages-wrapper .messages-title .return {
    background: transparent;
    border: 0;
    font-size: 25px;
    padding: 10px 0;
    cursor: pointer; }
.messages-wrapper .messages-body {
  height: calc(100vh - 290px);
  display: block;
  overflow-y: auto; }

.messages-wrapper .messages-body .message-content-wrapper, .conversations-body .message-content-wrapper {
  display: inline-block;
  width: 100%; }
.messages-wrapper .messages-body .message, .conversations-body .message {
  display: table;
  table-layout: fixed;
  padding: 8px 0; }
.messages-wrapper .messages-body .message-in, .conversations-body .message-in {
  margin-right: 40px;
  float: left; }
  .messages-wrapper .messages-body .message-in .message-body, .conversations-body .message-in .message-body {
    display: table-cell;
    vertical-align: top; }
    .messages-wrapper .messages-body .message-in .message-body .message-content, .conversations-body .message-in .message-body .message-content {
      background: #f7f7f7;
      padding: 12px 15px;
      border-radius: 5px;
      margin-left: 10px;
      position: relative;
      width: fit-content; }
      .messages-wrapper .messages-body .message-in .message-body .message-content:before, .conversations-body .message-in .message-body .message-content:before {
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 10px solid #f7f7f7;
        content: '';
        position: absolute;
        left: -10px;
        top: 12px; }
      .messages-wrapper .messages-body .message-in .message-body .message-content .name, .conversations-body .message-in .message-body .message-content .name {
        color: #83848a;
        font-size: 11px;
        margin-bottom: 5px; }
      .messages-wrapper .messages-body .message-in .message-body .message-content .content, .conversations-body .message-in .message-body .message-content .content {
        font-size: 13px; }
    .messages-wrapper .messages-body .message-in .message-body .date, .conversations-body .message-in .message-body .date {
      margin-left: 10px;
      margin-top: 8px;
      font-size: 11px;
      color: #83848a;
      padding-left: 12px; }
    .messages-wrapper .messages-body .message-in .message-body .message-content + .message-content, .conversations-body .message-in .message-body .message-content + .message-content {
      margin-top: 10px; }
      .messages-wrapper .messages-body .message-in .message-body .message-content + .message-content:before, .conversations-body .message-in .message-body .message-content + .message-content:before {
        display: none; }
.messages-wrapper .messages-body .message-out, .conversations-body .message-out {
  float: right;
  margin-left: 40px; }
  .messages-wrapper .messages-body .message-out .message-body, .conversations-body .message-out .message-body {
    display: table-cell;
    vertical-align: top;
    float: right; }
    .messages-wrapper .messages-body .message-out .message-body .message-content, .conversations-body .message-out .message-body .message-content {
      background: #1572E8;
      padding: 12px 15px;
      border-radius: 5px;
      margin-right: 10px;
      position: relative;
      width: fit-content; }
      .messages-wrapper .messages-body .message-out .message-body .message-content:before, .conversations-body .message-out .message-body .message-content:before {
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-left: 10px solid #1572E8;
        content: '';
        position: absolute;
        right: -10px;
        top: 12px; }
      .messages-wrapper .messages-body .message-out .message-body .message-content .content, .conversations-body .message-out .message-body .message-content .content {
        font-size: 13px;
        color: #ffffff !important; }
    .messages-wrapper .messages-body .message-out .message-body .date, .conversations-body .message-out .message-body .date {
      margin-right: 10px;
      margin-top: 8px;
      font-size: 11px;
      color: #83848a;
      text-align: right;
      padding-right: 15px; }
    .messages-wrapper .messages-body .message-out .message-body .message-content + .message-content, .conversations-body .message-out .message-body .message-content + .message-content {
      margin-top: 10px; }
      .messages-wrapper .messages-body .message-out .message-body .message-content + .message-content:before, .conversations-body .message-out .message-body .message-content + .message-content:before {
        display: none; }

.messages-form {
  display: table;
  width: 100%;
  margin-top: 30px;
  border-top: 1px solid #eee;
  padding-top: 20px; }
  .messages-form .messages-form-control {
    display: table-cell;
    padding-right: 15px; }
  .messages-form .messages-form-tool {
    display: table-cell;
    text-align: right;
    width: 50px; }
    .messages-form .messages-form-tool .attachment {
      height: 100%;
      line-height: 1;
      color: #888c91;
      background: #e8e8e8;
      font-size: 17px;
      padding: 10px 12px;
      border-radius: 50%;
      margin-left: auto; }

.show-chat .messages-contact {
  left: calc(-100% - 40px); }
.show-chat .messages-wrapper {
  left: 0px; }

/* 		List Group Messages 	*/
.list-group-messages .btn-dropdown {
  background: transparent;
  border: 0;
  font-size: 16px;
  color: #b5b5b5;
  line-height: 1;
  cursor: pointer;
  padding: 4px 10px; }
.list-group-messages .list-group-item {
  padding-top: 1.25rem;
  padding-bottom: 1.25rem; }
  .list-group-messages .list-group-item.unread .list-group-item-title {
    font-weight: 600; }
.list-group-messages .list-group-item-title a {
  color: #2A2F5B; }

/*      Conversations Wrapper     */
.conversations {
  display: flex;
  height: calc(100vh - 57px);
  flex-direction: column; }
  .conversations .message-header {
    background: #fff;
    padding: .5rem;
    box-shadow: 0 1px 0 0 rgba(61, 70, 79, 0.075);
    z-index: 1; }
  .conversations .message-title {
    width: 100%;
    display: flex;
    align-items: center;
    position: relative; }
    .conversations .message-title .user {
      display: flex;
      align-items: center;
      justify-content: center; }
      .conversations .message-title .user .name {
        display: block;
        font-size: 14px;
        font-weight: 600;
        line-height: 24px;
        margin-bottom: 2px; }
      .conversations .message-title .user .last-active {
        display: block;
        font-size: 11px; }
    .conversations .message-title .return {
      background: transparent;
      border: 0;
      font-size: 25px;
      cursor: pointer;
      height: 100%;
      top: 0; }
  .conversations .conversations-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 2rem; }
  .conversations .conversations-content {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 1rem; }
  .conversations .messages-form {
    margin: 0;
    padding: .7rem 1rem;
    background: #fff; }

.conversations-action {
  background: #f6f6f6;
  padding: 10px 0; }
  .conversations-action .action {
    display: flex;
    padding: 1rem 1.5rem;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    margin-bottom: 10px;
    cursor: pointer; }
    .conversations-action .action:hover {
      background: #f4f5f5; }
    .conversations-action .action span {
      font-size: 16px;
      line-height: 21px; }
    .conversations-action .action i {
      font-size: 21px;
      width: 2.5rem;
      color: rgba(38, 50, 56, 0.5); }
    .conversations-action .action.danger span, .conversations-action .action.danger i {
      color: #F25961; }
    .conversations-action .action:last-child {
      margin-bottom: 0px; }

@media screen and (max-width: 991px) {
  .conversations {
    margin-left: -15px;
    margin-right: -15px; } }
/*     	Task Tab     */
.tasks-wrapper .tasks-scroll {
  height: calc(100vh - 130px);
  overflow: auto;
  margin-bottom: 15px; }
.tasks-wrapper .tasks-content {
  padding-bottom: 25px; }
  .tasks-wrapper .tasks-content .tasks-list {
    padding: 0px 10px;
    list-style: none; }
    .tasks-wrapper .tasks-content .tasks-list li {
      position: relative;
      margin-bottom: 15px; }
      .tasks-wrapper .tasks-content .tasks-list li .custom-control {
        position: unset !important; }
      .tasks-wrapper .tasks-content .tasks-list li input[type="checkbox"]:checked ~ .custom-control-label {
        text-decoration: line-through;
        color: #999; }
      .tasks-wrapper .tasks-content .tasks-list li .custom-control.custom-checkbox {
        margin-right: 50px !important; }
      .tasks-wrapper .tasks-content .tasks-list li .task-action {
        display: none;
        position: absolute;
        font-size: 17px;
        right: 0;
        top: 0; }
        .tasks-wrapper .tasks-content .tasks-list li .task-action a.link {
          margin-left: 10px; }
          .tasks-wrapper .tasks-content .tasks-list li .task-action a.link:hover {
            text-decoration: none;
            color: unset; }
      .tasks-wrapper .tasks-content .tasks-list li:hover .task-action {
        display: block; }

/*     	Setting Tab     */
.settings-wrapper .settings-content .settings-list {
  padding-left: 0px;
  list-style: none; }
  .settings-wrapper .settings-content .settings-list li {
    display: table;
    width: 100%;
    margin-bottom: 15px; }
    .settings-wrapper .settings-content .settings-list li .item-label {
      display: table-cell;
      vertical-align: middle;
      font-size: 13px; }
    .settings-wrapper .settings-content .settings-list li .item-control {
      display: table-cell;
      float: right;
      margin-right: 5px; }
      .settings-wrapper .settings-content .settings-list li .item-control .toggle-group .toggle-on, .settings-wrapper .settings-content .settings-list li .item-control .toggle-group .toggle-off {
        font-size: 11px !important; }

.tile {
  width: 36px;
  height: 36px;
  font-size: 20px;
  border-radius: 50%;
  text-align: center;
  line-height: 36px; }
  .tile:hover {
    text-decoration: none; }
  .tile[class*="bg-"] {
    color: #fff; }

.row-projects {
  margin-right: -10px;
  margin-left: -10px; }
  .row-projects [class^="col-"] {
    padding: 0 10px; }

.loader, .is-loading:after {
  display: block;
  width: 1.5rem;
  height: 1.5rem;
  background: transparent;
  border: 3px solid #6861CE;
  border-bottom-color: transparent;
  border-radius: 50%;
  animation: 1s spin linear infinite; }

.loader-lg, .is-loading-lg:after {
  width: 2rem;
  height: 2rem;
  border-width: 5px; }

.loader-sm, .is-loading-sm:after {
  width: 1rem;
  height: 1rem;
  border-width: 2px; }

.is-loading {
  position: relative;
  color: transparent !important; }
  .is-loading > * {
    opacity: 0.2 !important; }
  .is-loading:after {
    position: absolute;
    top: calc(50% - 1.5rem/2);
    left: calc(50% - 1.5rem/2);
    content: ''; }

.is-loading-lg:after {
  top: calc(50% - 2rem/2);
  left: calc(50% - 2rem/2); }

.is-loading-sm:after {
  top: calc(50% - 1rem/2);
  left: calc(50% - 1rem/2); }

.btn-black.is-loading:after, .card-black.is-loading:after, .btn-primary.is-loading:after, .card-primary.is-loading:after, .btn-secondary.is-loading:after, .card-secondary.is-loading:after, .btn-info.is-loading:after, .card-info.is-loading:after, .btn-success.is-loading:after, .card-success.is-loading:after, .btn-warning.is-loading:after, .card-warning.is-loading:after, .btn-danger.is-loading:after, .card-danger.is-loading:after, .loader-black,
.is-loading-black:after, .loader-primary,
.is-loading-primary:after, .loader-secondary,
.is-loading-secondary:after, .loader-info,
.is-loading-info:after, .loader-success,
.is-loading-success:after, .loader-warning,
.is-loading-warning:after, .loader-danger,
.is-loading-danger:after {
  border-bottom-color: transparent !important; }

.btn-black.is-loading:after, .card-black.is-loading:after, .btn-primary.is-loading:after, .card-primary.is-loading:after, .btn-secondary.is-loading:after, .card-secondary.is-loading:after, .btn-info.is-loading:after, .card-info.is-loading:after, .btn-success.is-loading:after, .card-success.is-loading:after, .btn-warning.is-loading:after, .card-warning.is-loading:after, .btn-danger.is-loading:after, .card-danger.is-loading:after {
  border-color: #fff; }

.loader-black,
.is-loading-black:after {
  border-color: #1a2035; }

.loader-primary,
.is-loading-primary:after {
  border-color: #1572E8; }

.loader-secondary,
.is-loading-secondary:after {
  border-color: #6861CE; }

.loader-info,
.is-loading-info:after {
  border-color: #48ABF7; }

.loader-success,
.is-loading-success:after {
  border-color: #31CE36; }

.loader-warning,
.is-loading-warning:after {
  border-color: #FFAD46; }

.loader-danger,
.is-loading-danger:after {
  border-color: #F25961; }

@keyframes spin {
  from {
    transform: rotate(0deg); }
  to {
    transform: rotate(360deg); } }
/*      jQuery Ui     */
.ui-draggable-handle {
  -ms-touch-action: none;
  touch-action: none; }

.ui-helper-hidden {
  display: none; }

.ui-helper-hidden-accessible {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px; }

.ui-helper-reset {
  margin: 0;
  padding: 0;
  border: 0;
  outline: 0;
  line-height: 1.3;
  text-decoration: none;
  font-size: 100%;
  list-style: none; }

.ui-helper-clearfix:after, .ui-helper-clearfix:before {
  content: "";
  display: table;
  border-collapse: collapse; }
.ui-helper-clearfix:after {
  clear: both; }

.ui-helper-zfix {
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: absolute;
  opacity: 0;
  filter: Alpha(Opacity=0); }

.ui-front {
  z-index: 100; }

.ui-state-disabled {
  cursor: default !important;
  pointer-events: none; }

.ui-icon {
  display: inline-block;
  vertical-align: middle;
  margin-top: -.25em;
  position: relative;
  text-indent: -99999px;
  overflow: hidden;
  background-repeat: no-repeat; }

.ui-widget-icon-block {
  left: 50%;
  margin-left: -8px;
  display: block; }

.ui-widget-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; }

.ui-resizable {
  position: relative; }

.ui-resizable-handle {
  position: absolute;
  font-size: .1px;
  display: block;
  -ms-touch-action: none;
  touch-action: none; }

.ui-resizable-autohide .ui-resizable-handle, .ui-resizable-disabled .ui-resizable-handle {
  display: none; }

.ui-resizable-n {
  cursor: n-resize;
  height: 7px;
  width: 100%;
  top: -5px;
  left: 0; }

.ui-resizable-s {
  cursor: s-resize;
  height: 7px;
  width: 100%;
  bottom: -5px;
  left: 0; }

.ui-resizable-e {
  cursor: e-resize;
  width: 7px;
  right: -5px;
  top: 0;
  height: 100%; }

.ui-resizable-w {
  cursor: w-resize;
  width: 7px;
  left: -5px;
  top: 0;
  height: 100%; }

.ui-resizable-se {
  cursor: se-resize;
  width: 12px;
  height: 12px;
  right: 1px;
  bottom: 1px; }

.ui-resizable-sw {
  cursor: sw-resize;
  width: 9px;
  height: 9px;
  left: -5px;
  bottom: -5px; }

.ui-resizable-nw {
  cursor: nw-resize;
  width: 9px;
  height: 9px;
  left: -5px;
  top: -5px; }

.ui-resizable-ne {
  cursor: ne-resize;
  width: 9px;
  height: 9px;
  right: -5px;
  top: -5px; }

.ui-selectable {
  -ms-touch-action: none;
  touch-action: none; }

.ui-selectable-helper {
  position: absolute;
  z-index: 100;
  border: 1px dotted #000; }

.ui-sortable-handle {
  -ms-touch-action: none;
  touch-action: none; }

.ui-slider {
  position: relative;
  text-align: left;
  background: #ddd; }
  .ui-slider .ui-slider-handle {
    position: absolute;
    z-index: 2;
    width: 1em;
    height: 1em;
    cursor: default;
    -ms-touch-action: none;
    touch-action: none; }
  .ui-slider .ui-slider-range {
    position: absolute;
    z-index: 1;
    font-size: .7em;
    display: block;
    border: 0;
    background-position: 0 0; }
  .ui-slider.ui-state-disabled .ui-slider-handle, .ui-slider.ui-state-disabled .ui-slider-range {
    filter: inherit; }

.ui-slider-horizontal {
  height: .4em; }
  .ui-slider-horizontal .ui-slider-handle {
    top: -.4em;
    margin-left: -.6em; }
  .ui-slider-horizontal .ui-slider-range {
    top: 0;
    height: 100%; }
  .ui-slider-horizontal .ui-slider-range-min {
    left: 0; }
  .ui-slider-horizontal .ui-slider-range-max {
    right: 0; }

.ui-slider-vertical {
  width: .8em;
  height: 100px; }
  .ui-slider-vertical .ui-slider-handle {
    left: -.3em;
    margin-left: 0;
    margin-bottom: -.6em; }
  .ui-slider-vertical .ui-slider-range {
    left: 0;
    width: 100%; }
  .ui-slider-vertical .ui-slider-range-min {
    bottom: 0; }
  .ui-slider-vertical .ui-slider-range-max {
    top: 0; }

.ui-slider-handle {
  background: #ffffff;
  background: -moz-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ffffff), color-stop(100%, #f7f7f7));
  background: -webkit-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
  background: -o-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
  background: -ms-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
  background: linear-gradient(to bottom, #ffffff 0, #f7f7f7 100%);
  border-radius: 50px;
  box-shadow: 0 1px 4px 0 #9191ab !important; }
  .ui-slider-handle:focus {
    background: #ffffff;
    background: -moz-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ffffff), color-stop(100%, #f7f7f7));
    background: -webkit-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
    background: -o-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
    background: -ms-linear-gradient(top, #ffffff 0, #f7f7f7 100%);
    background: linear-gradient(to bottom, #ffffff 0, #f7f7f7 100%);
    border-radius: 50px;
    box-shadow: 0 1px 4px 0 #9191ab !important; }

/*      jQuery Scrollbar     */
.scroll-wrapper {
  overflow: hidden !important;
  padding: 0 !important;
  position: relative; }
  .scroll-wrapper > .scroll-content {
    border: none !important;
    box-sizing: content-box !important;
    height: auto;
    left: 0;
    margin: 0;
    max-height: none;
    max-width: none !important;
    overflow: scroll !important;
    padding: 0;
    position: relative !important;
    top: 0;
    width: auto !important; }
    .scroll-wrapper > .scroll-content::-webkit-scrollbar {
      height: 0;
      width: 0; }

.scroll-element {
  display: none;
  box-sizing: content-box; }
  .scroll-element div {
    box-sizing: content-box; }
  .scroll-element.scroll-x.scroll-scrollx_visible, .scroll-element.scroll-y.scroll-scrolly_visible {
    display: block; }
  .scroll-element .scroll-arrow, .scroll-element .scroll-bar {
    cursor: default; }

.scroll-textarea {
  border: 1px solid #ccc;
  border-top-color: #999; }
  .scroll-textarea > .scroll-content {
    overflow: hidden !important; }
    .scroll-textarea > .scroll-content > textarea {
      border: none !important;
      box-sizing: border-box;
      height: 100% !important;
      margin: 0;
      max-height: none !important;
      max-width: none !important;
      overflow: scroll !important;
      outline: 0;
      padding: 2px;
      position: relative !important;
      top: 0;
      width: 100% !important; }

.scrollbar-inner > .scroll-element .scroll-element_outer, .scrollbar-outer > .scroll-element .scroll-element_outer {
  overflow: hidden; }

.scroll-textarea > .scroll-content > textarea::-webkit-scrollbar {
  height: 0;
  width: 0; }

.scrollbar-inner > .scroll-element {
  border: none;
  margin: 0;
  padding: 0;
  position: absolute;
  z-index: 10; }
  .scrollbar-inner > .scroll-element div {
    border: none;
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-inner > .scroll-element.scroll-x {
    bottom: 2px;
    height: 7px;
    left: 0;
    width: 100%; }
    .scrollbar-inner > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size, .scrollbar-inner > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_track {
      left: -12px; }
  .scrollbar-inner > .scroll-element.scroll-y {
    height: 100%;
    right: 2px;
    top: 0;
    width: 7px; }
    .scrollbar-inner > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size, .scrollbar-inner > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_track {
      top: -12px; }
  .scrollbar-inner > .scroll-element .scroll-bar, .scrollbar-inner > .scroll-element .scroll-element_outer, .scrollbar-inner > .scroll-element .scroll-element_track {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px; }
  .scrollbar-inner > .scroll-element .scroll-bar {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
    filter: alpha(opacity=40);
    opacity: .4; }
  .scrollbar-inner > .scroll-element .scroll-element_track {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
    filter: alpha(opacity=40);
    opacity: .4;
    background-color: #e0e0e0; }
  .scrollbar-inner > .scroll-element .scroll-bar {
    background-color: #c2c2c2; }
  .scrollbar-inner > .scroll-element.scroll-draggable .scroll-bar, .scrollbar-inner > .scroll-element:hover .scroll-bar {
    background-color: #919191; }

.scrollbar-outer > .scroll-element {
  border: none;
  margin: 0;
  padding: 0;
  position: absolute;
  z-index: 10;
  background-color: #ffffff; }
  .scrollbar-outer > .scroll-element div {
    border: none;
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-outer > .scroll-element.scroll-x {
    bottom: 0;
    height: 12px;
    left: 0;
    width: 100%; }
  .scrollbar-outer > .scroll-element.scroll-y {
    height: 100%;
    right: 0;
    top: 0;
    width: 12px; }
  .scrollbar-outer > .scroll-element.scroll-x .scroll-element_outer {
    height: 7px;
    top: 2px; }
  .scrollbar-outer > .scroll-element.scroll-y .scroll-element_outer {
    left: 2px;
    width: 7px; }
  .scrollbar-outer > .scroll-element .scroll-element_track {
    background-color: #eee; }
  .scrollbar-outer > .scroll-element .scroll-bar, .scrollbar-outer > .scroll-element .scroll-element_outer, .scrollbar-outer > .scroll-element .scroll-element_track {
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px; }
  .scrollbar-outer > .scroll-element .scroll-bar {
    background-color: #d9d9d9; }
    .scrollbar-outer > .scroll-element .scroll-bar:hover {
      background-color: #c2c2c2; }
  .scrollbar-outer > .scroll-element.scroll-draggable .scroll-bar {
    background-color: #919191; }
.scrollbar-outer > .scroll-content.scroll-scrolly_visible {
  left: -12px;
  margin-left: 12px; }
.scrollbar-outer > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size, .scrollbar-outer > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_track {
  left: -14px; }
.scrollbar-outer > .scroll-content.scroll-scrollx_visible {
  top: -12px;
  margin-top: 12px; }
.scrollbar-outer > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size, .scrollbar-outer > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_track {
  top: -14px; }
.scrollbar-outer > .scroll-element.scroll-x .scroll-bar {
  min-width: 10px; }
.scrollbar-outer > .scroll-element.scroll-y .scroll-bar {
  min-height: 10px; }

.scrollbar-macosx > .scroll-element {
  background: 0 0;
  border: none;
  margin: 0;
  padding: 0;
  position: absolute;
  z-index: 10; }
  .scrollbar-macosx > .scroll-element div {
    background: 0 0;
    border: none;
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-macosx > .scroll-element .scroll-element_track {
    display: none; }
  .scrollbar-macosx > .scroll-element .scroll-bar {
    background-color: #6C6E71;
    display: block;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    opacity: 0;
    -webkit-border-radius: 7px;
    -moz-border-radius: 7px;
    border-radius: 7px;
    -webkit-transition: opacity .2s linear;
    -moz-transition: opacity .2s linear;
    -o-transition: opacity .2s linear;
    -ms-transition: opacity .2s linear;
    transition: opacity .2s linear; }
.scrollbar-macosx:hover > .scroll-element .scroll-bar {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
  filter: alpha(opacity=70);
  opacity: .7; }
.scrollbar-macosx > .scroll-element.scroll-draggable .scroll-bar {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
  filter: alpha(opacity=70);
  opacity: .7; }
.scrollbar-macosx > .scroll-element.scroll-x {
  bottom: 0;
  height: 0;
  left: 0;
  min-width: 100%;
  overflow: visible;
  width: 100%; }
.scrollbar-macosx > .scroll-element.scroll-y {
  height: 100%;
  min-height: 100%;
  right: 0;
  top: 0;
  width: 0; }
.scrollbar-macosx > .scroll-element.scroll-x .scroll-bar {
  height: 7px;
  min-width: 10px;
  top: -9px; }
.scrollbar-macosx > .scroll-element.scroll-y .scroll-bar {
  left: -9px;
  min-height: 10px;
  width: 7px; }
.scrollbar-macosx > .scroll-element.scroll-x .scroll-element_outer {
  left: 2px; }
.scrollbar-macosx > .scroll-element.scroll-x .scroll-element_size {
  left: -4px; }
.scrollbar-macosx > .scroll-element.scroll-y .scroll-element_outer {
  top: 2px; }
.scrollbar-macosx > .scroll-element.scroll-y .scroll-element_size {
  top: -4px; }
.scrollbar-macosx > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size {
  left: -11px; }
.scrollbar-macosx > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size {
  top: -11px; }

.scrollbar-light > .scroll-element {
  border: none;
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: absolute;
  z-index: 10;
  background-color: #ffffff; }
  .scrollbar-light > .scroll-element div {
    border: none;
    margin: 0;
    overflow: hidden;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-light > .scroll-element .scroll-element_outer {
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px; }
  .scrollbar-light > .scroll-element .scroll-element_size {
    background: -moz-linear-gradient(left, #dbdbdb 0, #e8e8e8 100%);
    background: -webkit-gradient(linear, left top, right top, color-stop(0, #dbdbdb), color-stop(100%, #e8e8e8));
    background: -webkit-linear-gradient(left, #dbdbdb 0, #e8e8e8 100%);
    background: -o-linear-gradient(left, #dbdbdb 0, #e8e8e8 100%);
    background: -ms-linear-gradient(left, #dbdbdb 0, #e8e8e8 100%);
    background: linear-gradient(to right, #dbdbdb 0, #e8e8e8 100%);
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px; }
  .scrollbar-light > .scroll-element.scroll-x {
    bottom: 0;
    height: 17px;
    left: 0;
    min-width: 100%;
    width: 100%; }
  .scrollbar-light > .scroll-element.scroll-y {
    height: 100%;
    min-height: 100%;
    right: 0;
    top: 0;
    width: 17px; }
  .scrollbar-light > .scroll-element .scroll-bar {
    background: -moz-linear-gradient(left, #fefefe 0, #f5f5f5 100%);
    background: -webkit-gradient(linear, left top, right top, color-stop(0, #fefefe), color-stop(100%, #f5f5f5));
    background: -webkit-linear-gradient(left, #fefefe 0, #f5f5f5 100%);
    background: -o-linear-gradient(left, #fefefe 0, #f5f5f5 100%);
    background: -ms-linear-gradient(left, #fefefe 0, #f5f5f5 100%);
    background: linear-gradient(to right, #fefefe 0, #f5f5f5 100%);
    border: 1px solid #dbdbdb;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px; }
.scrollbar-light > .scroll-content.scroll-scrolly_visible {
  left: -17px;
  margin-left: 17px; }
.scrollbar-light > .scroll-content.scroll-scrollx_visible {
  top: -17px;
  margin-top: 17px; }
.scrollbar-light > .scroll-element.scroll-x .scroll-bar {
  height: 10px;
  min-width: 10px;
  top: 0; }
.scrollbar-light > .scroll-element.scroll-y .scroll-bar {
  left: 0;
  min-height: 10px;
  width: 10px; }
.scrollbar-light > .scroll-element.scroll-x .scroll-element_outer {
  height: 12px;
  left: 2px;
  top: 2px; }
.scrollbar-light > .scroll-element.scroll-x .scroll-element_size {
  left: -4px; }
.scrollbar-light > .scroll-element.scroll-y .scroll-element_outer {
  left: 2px;
  top: 2px;
  width: 12px; }
.scrollbar-light > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size, .scrollbar-light > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_track {
  left: -19px; }
.scrollbar-light > .scroll-element.scroll-y .scroll-element_size {
  top: -4px; }
.scrollbar-light > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size, .scrollbar-light > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_track {
  top: -19px; }

.scrollbar-rail > .scroll-element {
  border: none;
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: absolute;
  z-index: 10;
  background-color: #ffffff; }
  .scrollbar-rail > .scroll-element div {
    border: none;
    margin: 0;
    overflow: hidden;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-rail > .scroll-element .scroll-element_size {
    background-color: #999;
    background-color: rgba(0, 0, 0, 0.3); }
  .scrollbar-rail > .scroll-element .scroll-element_outer:hover .scroll-element_size {
    background-color: #666;
    background-color: rgba(0, 0, 0, 0.5); }
  .scrollbar-rail > .scroll-element.scroll-x {
    bottom: 0;
    height: 12px;
    left: 0;
    min-width: 100%;
    padding: 3px 0 2px;
    width: 100%; }
  .scrollbar-rail > .scroll-element.scroll-y {
    height: 100%;
    min-height: 100%;
    padding: 0 2px 0 3px;
    right: 0;
    top: 0;
    width: 12px; }
  .scrollbar-rail > .scroll-element .scroll-bar {
    background-color: #d0b9a0;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); }
  .scrollbar-rail > .scroll-element .scroll-element_outer:hover .scroll-bar {
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6); }
.scrollbar-rail > .scroll-content.scroll-scrolly_visible {
  left: -17px;
  margin-left: 17px; }
.scrollbar-rail > .scroll-content.scroll-scrollx_visible {
  margin-top: 17px;
  top: -17px; }
.scrollbar-rail > .scroll-element.scroll-x .scroll-bar {
  height: 10px;
  min-width: 10px;
  top: 1px; }
.scrollbar-rail > .scroll-element.scroll-y .scroll-bar {
  left: 1px;
  min-height: 10px;
  width: 10px; }
.scrollbar-rail > .scroll-element.scroll-x .scroll-element_outer {
  height: 15px;
  left: 5px; }
.scrollbar-rail > .scroll-element.scroll-x .scroll-element_size {
  height: 2px;
  left: -10px;
  top: 5px; }
.scrollbar-rail > .scroll-element.scroll-y .scroll-element_outer {
  top: 5px;
  width: 15px; }
.scrollbar-rail > .scroll-element.scroll-y .scroll-element_size {
  left: 5px;
  top: -10px;
  width: 2px; }
.scrollbar-rail > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size, .scrollbar-rail > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_track {
  left: -25px; }
.scrollbar-rail > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size, .scrollbar-rail > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_track {
  top: -25px; }

.scrollbar-dynamic > .scroll-element {
  background: 0 0;
  border: none;
  margin: 0;
  padding: 0;
  position: absolute;
  z-index: 10; }
  .scrollbar-dynamic > .scroll-element div {
    background: 0 0;
    border: none;
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-dynamic > .scroll-element.scroll-x {
    bottom: 2px;
    height: 7px;
    left: 0;
    min-width: 100%;
    width: 100%; }
  .scrollbar-dynamic > .scroll-element.scroll-y {
    height: 100%;
    min-height: 100%;
    right: 2px;
    top: 0;
    width: 7px; }
  .scrollbar-dynamic > .scroll-element .scroll-element_outer {
    opacity: .3;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px; }
  .scrollbar-dynamic > .scroll-element .scroll-element_size {
    background-color: #ccc;
    opacity: 0;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
    -webkit-transition: opacity .2s;
    -moz-transition: opacity .2s;
    -o-transition: opacity .2s;
    -ms-transition: opacity .2s;
    transition: opacity .2s; }
  .scrollbar-dynamic > .scroll-element .scroll-bar {
    background-color: #6c6e71;
    -webkit-border-radius: 7px;
    -moz-border-radius: 7px;
    border-radius: 7px; }
  .scrollbar-dynamic > .scroll-element.scroll-x .scroll-bar {
    bottom: 0;
    height: 7px;
    min-width: 24px;
    top: auto; }
  .scrollbar-dynamic > .scroll-element.scroll-y .scroll-bar {
    left: auto;
    min-height: 24px;
    right: 0;
    width: 7px; }
  .scrollbar-dynamic > .scroll-element.scroll-x .scroll-element_outer {
    bottom: 0;
    top: auto;
    left: 2px;
    -webkit-transition: height .2s;
    -moz-transition: height .2s;
    -o-transition: height .2s;
    -ms-transition: height .2s;
    transition: height .2s; }
  .scrollbar-dynamic > .scroll-element.scroll-y .scroll-element_outer {
    left: auto;
    right: 0;
    top: 2px;
    -webkit-transition: width .2s;
    -moz-transition: width .2s;
    -o-transition: width .2s;
    -ms-transition: width .2s;
    transition: width .2s; }
  .scrollbar-dynamic > .scroll-element.scroll-x .scroll-element_size {
    left: -4px; }
  .scrollbar-dynamic > .scroll-element.scroll-y .scroll-element_size {
    top: -4px; }
  .scrollbar-dynamic > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size {
    left: -11px; }
  .scrollbar-dynamic > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size {
    top: -11px; }
  .scrollbar-dynamic > .scroll-element.scroll-draggable .scroll-element_outer, .scrollbar-dynamic > .scroll-element:hover .scroll-element_outer {
    overflow: hidden;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
    filter: alpha(opacity=70);
    opacity: .7; }
  .scrollbar-dynamic > .scroll-element.scroll-draggable .scroll-element_outer .scroll-element_size, .scrollbar-dynamic > .scroll-element:hover .scroll-element_outer .scroll-element_size {
    opacity: 1; }
  .scrollbar-dynamic > .scroll-element.scroll-draggable .scroll-element_outer .scroll-bar, .scrollbar-dynamic > .scroll-element:hover .scroll-element_outer .scroll-bar {
    height: 100%;
    width: 100%;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px; }
  .scrollbar-dynamic > .scroll-element.scroll-x.scroll-draggable .scroll-element_outer, .scrollbar-dynamic > .scroll-element.scroll-x:hover .scroll-element_outer {
    height: 20px;
    min-height: 7px; }
  .scrollbar-dynamic > .scroll-element.scroll-y.scroll-draggable .scroll-element_outer, .scrollbar-dynamic > .scroll-element.scroll-y:hover .scroll-element_outer {
    min-width: 7px;
    width: 20px; }

.scrollbar-chrome > .scroll-element {
  border: none;
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: absolute;
  z-index: 10;
  background-color: #ffffff; }
  .scrollbar-chrome > .scroll-element div {
    border: none;
    margin: 0;
    overflow: hidden;
    padding: 0;
    position: absolute;
    z-index: 10;
    display: block;
    height: 100%;
    left: 0;
    top: 0;
    width: 100%; }
  .scrollbar-chrome > .scroll-element .scroll-element_track {
    background: #f1f1f1;
    border: 1px solid #dbdbdb; }
  .scrollbar-chrome > .scroll-element.scroll-x {
    bottom: 0;
    height: 16px;
    left: 0;
    min-width: 100%;
    width: 100%; }
  .scrollbar-chrome > .scroll-element.scroll-y {
    height: 100%;
    min-height: 100%;
    right: 0;
    top: 0;
    width: 16px; }
  .scrollbar-chrome > .scroll-element .scroll-bar {
    background-color: #d9d9d9;
    border: 1px solid #bdbdbd;
    cursor: default;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px; }
    .scrollbar-chrome > .scroll-element .scroll-bar:hover {
      background-color: #c2c2c2;
      border-color: #a9a9a9; }
  .scrollbar-chrome > .scroll-element.scroll-draggable .scroll-bar {
    background-color: #919191;
    border-color: #7e7e7e; }
.scrollbar-chrome > .scroll-content.scroll-scrolly_visible {
  left: -16px;
  margin-left: 16px; }
.scrollbar-chrome > .scroll-content.scroll-scrollx_visible {
  top: -16px;
  margin-top: 16px; }
.scrollbar-chrome > .scroll-element.scroll-x .scroll-bar {
  height: 5px;
  min-width: 10px;
  top: 3px; }
.scrollbar-chrome > .scroll-element.scroll-y .scroll-bar {
  left: 3px;
  min-height: 10px;
  width: 5px; }
.scrollbar-chrome > .scroll-element.scroll-x .scroll-element_outer {
  border-left: 1px solid #dbdbdb; }
.scrollbar-chrome > .scroll-element.scroll-x .scroll-element_track {
  height: 14px;
  left: -3px; }
.scrollbar-chrome > .scroll-element.scroll-x .scroll-element_size {
  height: 14px;
  left: -4px; }
.scrollbar-chrome > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_size, .scrollbar-chrome > .scroll-element.scroll-x.scroll-scrolly_visible .scroll-element_track {
  left: -19px; }
.scrollbar-chrome > .scroll-element.scroll-y .scroll-element_outer {
  border-top: 1px solid #dbdbdb; }
.scrollbar-chrome > .scroll-element.scroll-y .scroll-element_track {
  top: -3px;
  width: 14px; }
.scrollbar-chrome > .scroll-element.scroll-y .scroll-element_size {
  top: -4px;
  width: 14px; }
.scrollbar-chrome > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_size, .scrollbar-chrome > .scroll-element.scroll-y.scroll-scrollx_visible .scroll-element_track {
  top: -19px; }

/*      Toggle     */
.checkbox label .toggle, .checkbox-inline .toggle {
  margin-left: -20px;
  margin-right: 5px; }

.toggle {
  position: relative;
  overflow: hidden;
  padding: .6rem .5rem; }

.toggle-group, .toggle-off, .toggle-on {
  position: absolute;
  top: 0;
  bottom: 0; }

.toggle input[type=checkbox] {
  display: none; }

.toggle-group {
  width: 200%;
  left: 0;
  transition: left .35s;
  -webkit-transition: left .35s;
  -moz-user-select: none;
  -webkit-user-select: none; }

.toggle.off .toggle-group {
  left: -100%; }

.toggle-on {
  left: 0;
  right: 50%;
  margin: 0;
  border: 0;
  border-radius: 0;
  padding-left: 12px !important;
  padding-top: 6px !important;
  padding-bottom: 6px !important;
  font-size: 11px !important; }

.toggle-off {
  left: 50%;
  right: 0;
  margin: 0;
  border: 0;
  border-radius: 0;
  padding-top: 6px !important;
  padding-bottom: 6px !important;
  font-size: 11px !important;
  color: #ffffff !important; }

.toggle-handle {
  position: relative;
  margin: 0 auto;
  padding-top: 0;
  padding-bottom: 0;
  height: 100%;
  width: 0;
  border-width: 0 1px; }

.toggle.btn {
  min-width: 54px !important;
  height: 30px !important; }

.toggle-on.btn {
  padding-right: 24px; }

.toggle-off.btn {
  padding-left: 24px; }

.toggle.btn-lg {
  min-width: 79px;
  min-height: 45px; }

.toggle-on.btn-lg {
  padding-right: 31px; }

.toggle-off.btn-lg {
  padding-left: 31px; }

.toggle-handle.btn-lg {
  width: 40px; }

.toggle.btn-sm {
  min-width: 50px;
  min-height: 30px; }

.toggle-on.btn-sm {
  padding-right: 20px; }

.toggle-off.btn-sm {
  padding-left: 20px; }

.toggle.btn-xs {
  min-width: 35px;
  min-height: 22px; }

.toggle-on.btn-xs {
  padding-right: 12px; }

.toggle-off.btn-xs {
  padding-left: 12px; }

/*!
* animate.css -http://daneden.me/animate
* Version - 3.6.0
* Licensed under the MIT license - http://opensource.org/licenses/MIT
*
* Copyright (c) 2018 Daniel Eden
*/
.animated {
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both; }
  .animated.infinite {
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite; }

@-webkit-keyframes bounce {
  from, 20%, 53%, 80%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  40%, 43% {
    -webkit-animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    -webkit-transform: translate3d(0, -30px, 0);
    transform: translate3d(0, -30px, 0); }
  70% {
    -webkit-animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    -webkit-transform: translate3d(0, -15px, 0);
    transform: translate3d(0, -15px, 0); }
  90% {
    -webkit-transform: translate3d(0, -4px, 0);
    transform: translate3d(0, -4px, 0); } }
@keyframes bounce {
  from, 20%, 53%, 80%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  40%, 43% {
    -webkit-animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    -webkit-transform: translate3d(0, -30px, 0);
    transform: translate3d(0, -30px, 0); }
  70% {
    -webkit-animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    -webkit-transform: translate3d(0, -15px, 0);
    transform: translate3d(0, -15px, 0); }
  90% {
    -webkit-transform: translate3d(0, -4px, 0);
    transform: translate3d(0, -4px, 0); } }
.bounce {
  -webkit-animation-name: bounce;
  animation-name: bounce;
  -webkit-transform-origin: center bottom;
  transform-origin: center bottom; }

@-webkit-keyframes flash {
  from, 50%, to {
    opacity: 1; }
  25%, 75% {
    opacity: 0; } }
@keyframes flash {
  from, 50%, to {
    opacity: 1; }
  25%, 75% {
    opacity: 0; } }
.flash {
  -webkit-animation-name: flash;
  animation-name: flash; }

/* originally authored by Nick Pettit - https://github.com/nickpettit/glide */
@-webkit-keyframes pulse {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  50% {
    -webkit-transform: scale3d(1.05, 1.05, 1.05);
    transform: scale3d(1.05, 1.05, 1.05); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
@keyframes pulse {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  50% {
    -webkit-transform: scale3d(1.05, 1.05, 1.05);
    transform: scale3d(1.05, 1.05, 1.05); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
.pulse {
  -webkit-animation-name: pulse;
  animation-name: pulse; }

@-webkit-keyframes rubberBand {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
    transform: scale3d(1.25, 0.75, 1); }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
    transform: scale3d(0.75, 1.25, 1); }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
    transform: scale3d(1.15, 0.85, 1); }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
    transform: scale3d(0.95, 1.05, 1); }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
    transform: scale3d(1.05, 0.95, 1); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
@keyframes rubberBand {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
    transform: scale3d(1.25, 0.75, 1); }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
    transform: scale3d(0.75, 1.25, 1); }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
    transform: scale3d(1.15, 0.85, 1); }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
    transform: scale3d(0.95, 1.05, 1); }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
    transform: scale3d(1.05, 0.95, 1); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
.rubberBand {
  -webkit-animation-name: rubberBand;
  animation-name: rubberBand; }

@-webkit-keyframes shake {
  from,
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  10%, 30%, 50%, 70%, 90% {
    -webkit-transform: translate3d(-10px, 0, 0);
    transform: translate3d(-10px, 0, 0); }
  20%, 40%, 60%, 80% {
    -webkit-transform: translate3d(10px, 0, 0);
    transform: translate3d(10px, 0, 0); } }
@keyframes shake {
  from,
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  10%, 30%, 50%, 70%, 90% {
    -webkit-transform: translate3d(-10px, 0, 0);
    transform: translate3d(-10px, 0, 0); }
  20%, 40%, 60%, 80% {
    -webkit-transform: translate3d(10px, 0, 0);
    transform: translate3d(10px, 0, 0); } }
.shake {
  -webkit-animation-name: shake;
  animation-name: shake; }

@-webkit-keyframes headShake {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0); }
  6.5% {
    -webkit-transform: translateX(-6px) rotateY(-9deg);
    transform: translateX(-6px) rotateY(-9deg); }
  18.5% {
    -webkit-transform: translateX(5px) rotateY(7deg);
    transform: translateX(5px) rotateY(7deg); }
  31.5% {
    -webkit-transform: translateX(-3px) rotateY(-5deg);
    transform: translateX(-3px) rotateY(-5deg); }
  43.5% {
    -webkit-transform: translateX(2px) rotateY(3deg);
    transform: translateX(2px) rotateY(3deg); }
  50% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }
@keyframes headShake {
  0% {
    -webkit-transform: translateX(0);
    transform: translateX(0); }
  6.5% {
    -webkit-transform: translateX(-6px) rotateY(-9deg);
    transform: translateX(-6px) rotateY(-9deg); }
  18.5% {
    -webkit-transform: translateX(5px) rotateY(7deg);
    transform: translateX(5px) rotateY(7deg); }
  31.5% {
    -webkit-transform: translateX(-3px) rotateY(-5deg);
    transform: translateX(-3px) rotateY(-5deg); }
  43.5% {
    -webkit-transform: translateX(2px) rotateY(3deg);
    transform: translateX(2px) rotateY(3deg); }
  50% {
    -webkit-transform: translateX(0);
    transform: translateX(0); } }
.headShake {
  -webkit-animation-timing-function: ease-in-out;
  animation-timing-function: ease-in-out;
  -webkit-animation-name: headShake;
  animation-name: headShake; }

@-webkit-keyframes swing {
  20% {
    -webkit-transform: rotate3d(0, 0, 1, 15deg);
    transform: rotate3d(0, 0, 1, 15deg); }
  40% {
    -webkit-transform: rotate3d(0, 0, 1, -10deg);
    transform: rotate3d(0, 0, 1, -10deg); }
  60% {
    -webkit-transform: rotate3d(0, 0, 1, 5deg);
    transform: rotate3d(0, 0, 1, 5deg); }
  80% {
    -webkit-transform: rotate3d(0, 0, 1, -5deg);
    transform: rotate3d(0, 0, 1, -5deg); }
  to {
    -webkit-transform: rotate3d(0, 0, 1, 0deg);
    transform: rotate3d(0, 0, 1, 0deg); } }
@keyframes swing {
  20% {
    -webkit-transform: rotate3d(0, 0, 1, 15deg);
    transform: rotate3d(0, 0, 1, 15deg); }
  40% {
    -webkit-transform: rotate3d(0, 0, 1, -10deg);
    transform: rotate3d(0, 0, 1, -10deg); }
  60% {
    -webkit-transform: rotate3d(0, 0, 1, 5deg);
    transform: rotate3d(0, 0, 1, 5deg); }
  80% {
    -webkit-transform: rotate3d(0, 0, 1, -5deg);
    transform: rotate3d(0, 0, 1, -5deg); }
  to {
    -webkit-transform: rotate3d(0, 0, 1, 0deg);
    transform: rotate3d(0, 0, 1, 0deg); } }
.swing {
  -webkit-transform-origin: top center;
  transform-origin: top center;
  -webkit-animation-name: swing;
  animation-name: swing; }

@-webkit-keyframes tada {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  10%, 20% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
    transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg); }
  30%, 50%, 70%, 90% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
    transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg); }
  40%, 60%, 80% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
    transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
@keyframes tada {
  from {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); }
  10%, 20% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg);
    transform: scale3d(0.9, 0.9, 0.9) rotate3d(0, 0, 1, -3deg); }
  30%, 50%, 70%, 90% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg);
    transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, 3deg); }
  40%, 60%, 80% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg);
    transform: scale3d(1.1, 1.1, 1.1) rotate3d(0, 0, 1, -3deg); }
  to {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
.tada {
  -webkit-animation-name: tada;
  animation-name: tada; }

/* originally authored by Nick Pettit - https://github.com/nickpettit/glide */
@-webkit-keyframes wobble {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  15% {
    -webkit-transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
    transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg); }
  30% {
    -webkit-transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
    transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg); }
  45% {
    -webkit-transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
    transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg); }
  60% {
    -webkit-transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
    transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg); }
  75% {
    -webkit-transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
    transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes wobble {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  15% {
    -webkit-transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
    transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg); }
  30% {
    -webkit-transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
    transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg); }
  45% {
    -webkit-transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
    transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg); }
  60% {
    -webkit-transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
    transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg); }
  75% {
    -webkit-transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
    transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.wobble {
  -webkit-animation-name: wobble;
  animation-name: wobble; }

@-webkit-keyframes jello {
  from, 11.1%, to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  22.2% {
    -webkit-transform: skewX(-12.5deg) skewY(-12.5deg);
    transform: skewX(-12.5deg) skewY(-12.5deg); }
  33.3% {
    -webkit-transform: skewX(6.25deg) skewY(6.25deg);
    transform: skewX(6.25deg) skewY(6.25deg); }
  44.4% {
    -webkit-transform: skewX(-3.125deg) skewY(-3.125deg);
    transform: skewX(-3.125deg) skewY(-3.125deg); }
  55.5% {
    -webkit-transform: skewX(1.5625deg) skewY(1.5625deg);
    transform: skewX(1.5625deg) skewY(1.5625deg); }
  66.6% {
    -webkit-transform: skewX(-0.78125deg) skewY(-0.78125deg);
    transform: skewX(-0.78125deg) skewY(-0.78125deg); }
  77.7% {
    -webkit-transform: skewX(0.39063deg) skewY(0.39063deg);
    transform: skewX(0.39063deg) skewY(0.39063deg); }
  88.8% {
    -webkit-transform: skewX(-0.19531deg) skewY(-0.19531deg);
    transform: skewX(-0.19531deg) skewY(-0.19531deg); } }
@keyframes jello {
  from, 11.1%, to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  22.2% {
    -webkit-transform: skewX(-12.5deg) skewY(-12.5deg);
    transform: skewX(-12.5deg) skewY(-12.5deg); }
  33.3% {
    -webkit-transform: skewX(6.25deg) skewY(6.25deg);
    transform: skewX(6.25deg) skewY(6.25deg); }
  44.4% {
    -webkit-transform: skewX(-3.125deg) skewY(-3.125deg);
    transform: skewX(-3.125deg) skewY(-3.125deg); }
  55.5% {
    -webkit-transform: skewX(1.5625deg) skewY(1.5625deg);
    transform: skewX(1.5625deg) skewY(1.5625deg); }
  66.6% {
    -webkit-transform: skewX(-0.78125deg) skewY(-0.78125deg);
    transform: skewX(-0.78125deg) skewY(-0.78125deg); }
  77.7% {
    -webkit-transform: skewX(0.39063deg) skewY(0.39063deg);
    transform: skewX(0.39063deg) skewY(0.39063deg); }
  88.8% {
    -webkit-transform: skewX(-0.19531deg) skewY(-0.19531deg);
    transform: skewX(-0.19531deg) skewY(-0.19531deg); } }
.jello {
  -webkit-animation-name: jello;
  animation-name: jello;
  -webkit-transform-origin: center;
  transform-origin: center; }

@-webkit-keyframes bounceIn {
  from, 20%, 40%, 60%, 80%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  20% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1); }
  40% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9);
    transform: scale3d(0.9, 0.9, 0.9); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(1.03, 1.03, 1.03);
    transform: scale3d(1.03, 1.03, 1.03); }
  80% {
    -webkit-transform: scale3d(0.97, 0.97, 0.97);
    transform: scale3d(0.97, 0.97, 0.97); }
  to {
    opacity: 1;
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
@keyframes bounceIn {
  from, 20%, 40%, 60%, 80%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  20% {
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1); }
  40% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9);
    transform: scale3d(0.9, 0.9, 0.9); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(1.03, 1.03, 1.03);
    transform: scale3d(1.03, 1.03, 1.03); }
  80% {
    -webkit-transform: scale3d(0.97, 0.97, 0.97);
    transform: scale3d(0.97, 0.97, 0.97); }
  to {
    opacity: 1;
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1); } }
.bounceIn {
  -webkit-animation-duration: 0.75s;
  animation-duration: 0.75s;
  -webkit-animation-name: bounceIn;
  animation-name: bounceIn; }

@-webkit-keyframes bounceInDown {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -3000px, 0);
    transform: translate3d(0, -3000px, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(0, 25px, 0);
    transform: translate3d(0, 25px, 0); }
  75% {
    -webkit-transform: translate3d(0, -10px, 0);
    transform: translate3d(0, -10px, 0); }
  90% {
    -webkit-transform: translate3d(0, 5px, 0);
    transform: translate3d(0, 5px, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes bounceInDown {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -3000px, 0);
    transform: translate3d(0, -3000px, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(0, 25px, 0);
    transform: translate3d(0, 25px, 0); }
  75% {
    -webkit-transform: translate3d(0, -10px, 0);
    transform: translate3d(0, -10px, 0); }
  90% {
    -webkit-transform: translate3d(0, 5px, 0);
    transform: translate3d(0, 5px, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.bounceInDown {
  -webkit-animation-name: bounceInDown;
  animation-name: bounceInDown; }

@-webkit-keyframes bounceInLeft {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: translate3d(-3000px, 0, 0);
    transform: translate3d(-3000px, 0, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(25px, 0, 0);
    transform: translate3d(25px, 0, 0); }
  75% {
    -webkit-transform: translate3d(-10px, 0, 0);
    transform: translate3d(-10px, 0, 0); }
  90% {
    -webkit-transform: translate3d(5px, 0, 0);
    transform: translate3d(5px, 0, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes bounceInLeft {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  0% {
    opacity: 0;
    -webkit-transform: translate3d(-3000px, 0, 0);
    transform: translate3d(-3000px, 0, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(25px, 0, 0);
    transform: translate3d(25px, 0, 0); }
  75% {
    -webkit-transform: translate3d(-10px, 0, 0);
    transform: translate3d(-10px, 0, 0); }
  90% {
    -webkit-transform: translate3d(5px, 0, 0);
    transform: translate3d(5px, 0, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.bounceInLeft {
  -webkit-animation-name: bounceInLeft;
  animation-name: bounceInLeft; }

@-webkit-keyframes bounceInRight {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  from {
    opacity: 0;
    -webkit-transform: translate3d(3000px, 0, 0);
    transform: translate3d(3000px, 0, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(-25px, 0, 0);
    transform: translate3d(-25px, 0, 0); }
  75% {
    -webkit-transform: translate3d(10px, 0, 0);
    transform: translate3d(10px, 0, 0); }
  90% {
    -webkit-transform: translate3d(-5px, 0, 0);
    transform: translate3d(-5px, 0, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes bounceInRight {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  from {
    opacity: 0;
    -webkit-transform: translate3d(3000px, 0, 0);
    transform: translate3d(3000px, 0, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(-25px, 0, 0);
    transform: translate3d(-25px, 0, 0); }
  75% {
    -webkit-transform: translate3d(10px, 0, 0);
    transform: translate3d(10px, 0, 0); }
  90% {
    -webkit-transform: translate3d(-5px, 0, 0);
    transform: translate3d(-5px, 0, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.bounceInRight {
  -webkit-animation-name: bounceInRight;
  animation-name: bounceInRight; }

@-webkit-keyframes bounceInUp {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 3000px, 0);
    transform: translate3d(0, 3000px, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(0, -20px, 0);
    transform: translate3d(0, -20px, 0); }
  75% {
    -webkit-transform: translate3d(0, 10px, 0);
    transform: translate3d(0, 10px, 0); }
  90% {
    -webkit-transform: translate3d(0, -5px, 0);
    transform: translate3d(0, -5px, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes bounceInUp {
  from, 60%, 75%, 90%, to {
    -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 3000px, 0);
    transform: translate3d(0, 3000px, 0); }
  60% {
    opacity: 1;
    -webkit-transform: translate3d(0, -20px, 0);
    transform: translate3d(0, -20px, 0); }
  75% {
    -webkit-transform: translate3d(0, 10px, 0);
    transform: translate3d(0, 10px, 0); }
  90% {
    -webkit-transform: translate3d(0, -5px, 0);
    transform: translate3d(0, -5px, 0); }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.bounceInUp {
  -webkit-animation-name: bounceInUp;
  animation-name: bounceInUp; }

@-webkit-keyframes bounceOut {
  20% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9);
    transform: scale3d(0.9, 0.9, 0.9); }
  50%, 55% {
    opacity: 1;
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); } }
@keyframes bounceOut {
  20% {
    -webkit-transform: scale3d(0.9, 0.9, 0.9);
    transform: scale3d(0.9, 0.9, 0.9); }
  50%, 55% {
    opacity: 1;
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); } }
.bounceOut {
  -webkit-animation-duration: 0.75s;
  animation-duration: 0.75s;
  -webkit-animation-name: bounceOut;
  animation-name: bounceOut; }

@-webkit-keyframes bounceOutDown {
  20% {
    -webkit-transform: translate3d(0, 10px, 0);
    transform: translate3d(0, 10px, 0); }
  40%, 45% {
    opacity: 1;
    -webkit-transform: translate3d(0, -20px, 0);
    transform: translate3d(0, -20px, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); } }
@keyframes bounceOutDown {
  20% {
    -webkit-transform: translate3d(0, 10px, 0);
    transform: translate3d(0, 10px, 0); }
  40%, 45% {
    opacity: 1;
    -webkit-transform: translate3d(0, -20px, 0);
    transform: translate3d(0, -20px, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); } }
.bounceOutDown {
  -webkit-animation-name: bounceOutDown;
  animation-name: bounceOutDown; }

@-webkit-keyframes bounceOutLeft {
  20% {
    opacity: 1;
    -webkit-transform: translate3d(20px, 0, 0);
    transform: translate3d(20px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); } }
@keyframes bounceOutLeft {
  20% {
    opacity: 1;
    -webkit-transform: translate3d(20px, 0, 0);
    transform: translate3d(20px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); } }
.bounceOutLeft {
  -webkit-animation-name: bounceOutLeft;
  animation-name: bounceOutLeft; }

@-webkit-keyframes bounceOutRight {
  20% {
    opacity: 1;
    -webkit-transform: translate3d(-20px, 0, 0);
    transform: translate3d(-20px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); } }
@keyframes bounceOutRight {
  20% {
    opacity: 1;
    -webkit-transform: translate3d(-20px, 0, 0);
    transform: translate3d(-20px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); } }
.bounceOutRight {
  -webkit-animation-name: bounceOutRight;
  animation-name: bounceOutRight; }

@-webkit-keyframes bounceOutUp {
  20% {
    -webkit-transform: translate3d(0, -10px, 0);
    transform: translate3d(0, -10px, 0); }
  40%, 45% {
    opacity: 1;
    -webkit-transform: translate3d(0, 20px, 0);
    transform: translate3d(0, 20px, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); } }
@keyframes bounceOutUp {
  20% {
    -webkit-transform: translate3d(0, -10px, 0);
    transform: translate3d(0, -10px, 0); }
  40%, 45% {
    opacity: 1;
    -webkit-transform: translate3d(0, 20px, 0);
    transform: translate3d(0, 20px, 0); }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); } }
.bounceOutUp {
  -webkit-animation-name: bounceOutUp;
  animation-name: bounceOutUp; }

@-webkit-keyframes fadeIn {
  from {
    opacity: 0; }
  to {
    opacity: 1; } }
@keyframes fadeIn {
  from {
    opacity: 0; }
  to {
    opacity: 1; } }
.fadeIn {
  -webkit-animation-name: fadeIn;
  animation-name: fadeIn; }

@-webkit-keyframes fadeInDown {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInDown {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown; }

@-webkit-keyframes fadeInDownBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInDownBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInDownBig {
  -webkit-animation-name: fadeInDownBig;
  animation-name: fadeInDownBig; }

@-webkit-keyframes fadeInLeft {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInLeft {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInLeft {
  -webkit-animation-name: fadeInLeft;
  animation-name: fadeInLeft; }

@-webkit-keyframes fadeInLeftBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInLeftBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInLeftBig {
  -webkit-animation-name: fadeInLeftBig;
  animation-name: fadeInLeftBig; }

@-webkit-keyframes fadeInRight {
  from {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInRight {
  from {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInRight {
  -webkit-animation-name: fadeInRight;
  animation-name: fadeInRight; }

@-webkit-keyframes fadeInRightBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInRightBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInRightBig {
  -webkit-animation-name: fadeInRightBig;
  animation-name: fadeInRightBig; }

@-webkit-keyframes fadeInUp {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInUp {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInUp {
  -webkit-animation-name: fadeInUp;
  animation-name: fadeInUp; }

@-webkit-keyframes fadeInUpBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes fadeInUpBig {
  from {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.fadeInUpBig {
  -webkit-animation-name: fadeInUpBig;
  animation-name: fadeInUpBig; }

@-webkit-keyframes fadeOut {
  from {
    opacity: 1; }
  to {
    opacity: 0; } }
@keyframes fadeOut {
  from {
    opacity: 1; }
  to {
    opacity: 0; } }
.fadeOut {
  -webkit-animation-name: fadeOut;
  animation-name: fadeOut; }

@-webkit-keyframes fadeOutDown {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); } }
@keyframes fadeOutDown {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); } }
.fadeOutDown {
  -webkit-animation-name: fadeOutDown;
  animation-name: fadeOutDown; }

@-webkit-keyframes fadeOutDownBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); } }
@keyframes fadeOutDownBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, 2000px, 0);
    transform: translate3d(0, 2000px, 0); } }
.fadeOutDownBig {
  -webkit-animation-name: fadeOutDownBig;
  animation-name: fadeOutDownBig; }

@-webkit-keyframes fadeOutLeft {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); } }
@keyframes fadeOutLeft {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); } }
.fadeOutLeft {
  -webkit-animation-name: fadeOutLeft;
  animation-name: fadeOutLeft; }

@-webkit-keyframes fadeOutLeftBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); } }
@keyframes fadeOutLeftBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(-2000px, 0, 0);
    transform: translate3d(-2000px, 0, 0); } }
.fadeOutLeftBig {
  -webkit-animation-name: fadeOutLeftBig;
  animation-name: fadeOutLeftBig; }

@-webkit-keyframes fadeOutRight {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); } }
@keyframes fadeOutRight {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); } }
.fadeOutRight {
  -webkit-animation-name: fadeOutRight;
  animation-name: fadeOutRight; }

@-webkit-keyframes fadeOutRightBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); } }
@keyframes fadeOutRightBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(2000px, 0, 0);
    transform: translate3d(2000px, 0, 0); } }
.fadeOutRightBig {
  -webkit-animation-name: fadeOutRightBig;
  animation-name: fadeOutRightBig; }

@-webkit-keyframes fadeOutUp {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); } }
@keyframes fadeOutUp {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); } }
.fadeOutUp {
  -webkit-animation-name: fadeOutUp;
  animation-name: fadeOutUp; }

@-webkit-keyframes fadeOutUpBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); } }
@keyframes fadeOutUpBig {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(0, -2000px, 0);
    transform: translate3d(0, -2000px, 0); } }
.fadeOutUpBig {
  -webkit-animation-name: fadeOutUpBig;
  animation-name: fadeOutUpBig; }

@-webkit-keyframes flip {
  from {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -360deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -360deg);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out; }
  40% {
    -webkit-transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -190deg);
    transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -190deg);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out; }
  50% {
    -webkit-transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -170deg);
    transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -170deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  80% {
    -webkit-transform: perspective(400px) scale3d(0.95, 0.95, 0.95);
    transform: perspective(400px) scale3d(0.95, 0.95, 0.95);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; } }
@keyframes flip {
  from {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -360deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -360deg);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out; }
  40% {
    -webkit-transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -190deg);
    transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -190deg);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out; }
  50% {
    -webkit-transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -170deg);
    transform: perspective(400px) translate3d(0, 0, 150px) rotate3d(0, 1, 0, -170deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  80% {
    -webkit-transform: perspective(400px) scale3d(0.95, 0.95, 0.95);
    transform: perspective(400px) scale3d(0.95, 0.95, 0.95);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; } }
.animated.flip {
  -webkit-backface-visibility: visible;
  backface-visibility: visible;
  -webkit-animation-name: flip;
  animation-name: flip; }

@-webkit-keyframes flipInX {
  from {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 0; }
  40% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  60% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
    opacity: 1; }
  80% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -5deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -5deg); }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); } }
@keyframes flipInX {
  from {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 0; }
  40% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  60% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
    opacity: 1; }
  80% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -5deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -5deg); }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); } }
.flipInX {
  -webkit-backface-visibility: visible !important;
  backface-visibility: visible !important;
  -webkit-animation-name: flipInX;
  animation-name: flipInX; }

@-webkit-keyframes flipInY {
  from {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 0; }
  40% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  60% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
    opacity: 1; }
  80% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -5deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -5deg); }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); } }
@keyframes flipInY {
  from {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 0; }
  40% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -20deg);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in; }
  60% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 10deg);
    opacity: 1; }
  80% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -5deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -5deg); }
  to {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); } }
.flipInY {
  -webkit-backface-visibility: visible !important;
  backface-visibility: visible !important;
  -webkit-animation-name: flipInY;
  animation-name: flipInY; }

@-webkit-keyframes flipOutX {
  from {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); }
  30% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    opacity: 1; }
  to {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    opacity: 0; } }
@keyframes flipOutX {
  from {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); }
  30% {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
    opacity: 1; }
  to {
    -webkit-transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
    opacity: 0; } }
.flipOutX {
  -webkit-animation-duration: 0.75s;
  animation-duration: 0.75s;
  -webkit-animation-name: flipOutX;
  animation-name: flipOutX;
  -webkit-backface-visibility: visible !important;
  backface-visibility: visible !important; }

@-webkit-keyframes flipOutY {
  from {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); }
  30% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -15deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -15deg);
    opacity: 1; }
  to {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    opacity: 0; } }
@keyframes flipOutY {
  from {
    -webkit-transform: perspective(400px);
    transform: perspective(400px); }
  30% {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, -15deg);
    transform: perspective(400px) rotate3d(0, 1, 0, -15deg);
    opacity: 1; }
  to {
    -webkit-transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    transform: perspective(400px) rotate3d(0, 1, 0, 90deg);
    opacity: 0; } }
.flipOutY {
  -webkit-animation-duration: 0.75s;
  animation-duration: 0.75s;
  -webkit-backface-visibility: visible !important;
  backface-visibility: visible !important;
  -webkit-animation-name: flipOutY;
  animation-name: flipOutY; }

@-webkit-keyframes lightSpeedIn {
  from {
    -webkit-transform: translate3d(100%, 0, 0) skewX(-30deg);
    transform: translate3d(100%, 0, 0) skewX(-30deg);
    opacity: 0; }
  60% {
    -webkit-transform: skewX(20deg);
    transform: skewX(20deg);
    opacity: 1; }
  80% {
    -webkit-transform: skewX(-5deg);
    transform: skewX(-5deg);
    opacity: 1; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes lightSpeedIn {
  from {
    -webkit-transform: translate3d(100%, 0, 0) skewX(-30deg);
    transform: translate3d(100%, 0, 0) skewX(-30deg);
    opacity: 0; }
  60% {
    -webkit-transform: skewX(20deg);
    transform: skewX(20deg);
    opacity: 1; }
  80% {
    -webkit-transform: skewX(-5deg);
    transform: skewX(-5deg);
    opacity: 1; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.lightSpeedIn {
  -webkit-animation-name: lightSpeedIn;
  animation-name: lightSpeedIn;
  -webkit-animation-timing-function: ease-out;
  animation-timing-function: ease-out; }

@-webkit-keyframes lightSpeedOut {
  from {
    opacity: 1; }
  to {
    -webkit-transform: translate3d(100%, 0, 0) skewX(30deg);
    transform: translate3d(100%, 0, 0) skewX(30deg);
    opacity: 0; } }
@keyframes lightSpeedOut {
  from {
    opacity: 1; }
  to {
    -webkit-transform: translate3d(100%, 0, 0) skewX(30deg);
    transform: translate3d(100%, 0, 0) skewX(30deg);
    opacity: 0; } }
.lightSpeedOut {
  -webkit-animation-name: lightSpeedOut;
  animation-name: lightSpeedOut;
  -webkit-animation-timing-function: ease-in;
  animation-timing-function: ease-in; }

@-webkit-keyframes rotateIn {
  from {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: rotate3d(0, 0, 1, -200deg);
    transform: rotate3d(0, 0, 1, -200deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes rotateIn {
  from {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: rotate3d(0, 0, 1, -200deg);
    transform: rotate3d(0, 0, 1, -200deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.rotateIn {
  -webkit-animation-name: rotateIn;
  animation-name: rotateIn; }

@-webkit-keyframes rotateInDownLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes rotateInDownLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.rotateInDownLeft {
  -webkit-animation-name: rotateInDownLeft;
  animation-name: rotateInDownLeft; }

@-webkit-keyframes rotateInDownRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes rotateInDownRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.rotateInDownRight {
  -webkit-animation-name: rotateInDownRight;
  animation-name: rotateInDownRight; }

@-webkit-keyframes rotateInUpLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes rotateInUpLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.rotateInUpLeft {
  -webkit-animation-name: rotateInUpLeft;
  animation-name: rotateInUpLeft; }

@-webkit-keyframes rotateInUpRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, -90deg);
    transform: rotate3d(0, 0, 1, -90deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
@keyframes rotateInUpRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, -90deg);
    transform: rotate3d(0, 0, 1, -90deg);
    opacity: 0; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    opacity: 1; } }
.rotateInUpRight {
  -webkit-animation-name: rotateInUpRight;
  animation-name: rotateInUpRight; }

@-webkit-keyframes rotateOut {
  from {
    -webkit-transform-origin: center;
    transform-origin: center;
    opacity: 1; }
  to {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: rotate3d(0, 0, 1, 200deg);
    transform: rotate3d(0, 0, 1, 200deg);
    opacity: 0; } }
@keyframes rotateOut {
  from {
    -webkit-transform-origin: center;
    transform-origin: center;
    opacity: 1; }
  to {
    -webkit-transform-origin: center;
    transform-origin: center;
    -webkit-transform: rotate3d(0, 0, 1, 200deg);
    transform: rotate3d(0, 0, 1, 200deg);
    opacity: 0; } }
.rotateOut {
  -webkit-animation-name: rotateOut;
  animation-name: rotateOut; }

@-webkit-keyframes rotateOutDownLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; } }
@keyframes rotateOutDownLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, 45deg);
    transform: rotate3d(0, 0, 1, 45deg);
    opacity: 0; } }
.rotateOutDownLeft {
  -webkit-animation-name: rotateOutDownLeft;
  animation-name: rotateOutDownLeft; }

@-webkit-keyframes rotateOutDownRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; } }
@keyframes rotateOutDownRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; } }
.rotateOutDownRight {
  -webkit-animation-name: rotateOutDownRight;
  animation-name: rotateOutDownRight; }

@-webkit-keyframes rotateOutUpLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; } }
@keyframes rotateOutUpLeft {
  from {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: left bottom;
    transform-origin: left bottom;
    -webkit-transform: rotate3d(0, 0, 1, -45deg);
    transform: rotate3d(0, 0, 1, -45deg);
    opacity: 0; } }
.rotateOutUpLeft {
  -webkit-animation-name: rotateOutUpLeft;
  animation-name: rotateOutUpLeft; }

@-webkit-keyframes rotateOutUpRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, 90deg);
    transform: rotate3d(0, 0, 1, 90deg);
    opacity: 0; } }
@keyframes rotateOutUpRight {
  from {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    opacity: 1; }
  to {
    -webkit-transform-origin: right bottom;
    transform-origin: right bottom;
    -webkit-transform: rotate3d(0, 0, 1, 90deg);
    transform: rotate3d(0, 0, 1, 90deg);
    opacity: 0; } }
.rotateOutUpRight {
  -webkit-animation-name: rotateOutUpRight;
  animation-name: rotateOutUpRight; }

@-webkit-keyframes hinge {
  0% {
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out; }
  20%, 60% {
    -webkit-transform: rotate3d(0, 0, 1, 80deg);
    transform: rotate3d(0, 0, 1, 80deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out; }
  40%, 80% {
    -webkit-transform: rotate3d(0, 0, 1, 60deg);
    transform: rotate3d(0, 0, 1, 60deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
    opacity: 1; }
  to {
    -webkit-transform: translate3d(0, 700px, 0);
    transform: translate3d(0, 700px, 0);
    opacity: 0; } }
@keyframes hinge {
  0% {
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out; }
  20%, 60% {
    -webkit-transform: rotate3d(0, 0, 1, 80deg);
    transform: rotate3d(0, 0, 1, 80deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out; }
  40%, 80% {
    -webkit-transform: rotate3d(0, 0, 1, 60deg);
    transform: rotate3d(0, 0, 1, 60deg);
    -webkit-transform-origin: top left;
    transform-origin: top left;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
    opacity: 1; }
  to {
    -webkit-transform: translate3d(0, 700px, 0);
    transform: translate3d(0, 700px, 0);
    opacity: 0; } }
.hinge {
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-name: hinge;
  animation-name: hinge; }

@-webkit-keyframes jackInTheBox {
  from {
    opacity: 0;
    -webkit-transform: scale(0.1) rotate(30deg);
    transform: scale(0.1) rotate(30deg);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom; }
  50% {
    -webkit-transform: rotate(-10deg);
    transform: rotate(-10deg); }
  70% {
    -webkit-transform: rotate(3deg);
    transform: rotate(3deg); }
  to {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1); } }
@keyframes jackInTheBox {
  from {
    opacity: 0;
    -webkit-transform: scale(0.1) rotate(30deg);
    transform: scale(0.1) rotate(30deg);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom; }
  50% {
    -webkit-transform: rotate(-10deg);
    transform: rotate(-10deg); }
  70% {
    -webkit-transform: rotate(3deg);
    transform: rotate(3deg); }
  to {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1); } }
.jackInTheBox {
  -webkit-animation-name: jackInTheBox;
  animation-name: jackInTheBox; }

/* originally authored by Nick Pettit - https://github.com/nickpettit/glide */
@-webkit-keyframes rollIn {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
    transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes rollIn {
  from {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg);
    transform: translate3d(-100%, 0, 0) rotate3d(0, 0, 1, -120deg); }
  to {
    opacity: 1;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.rollIn {
  -webkit-animation-name: rollIn;
  animation-name: rollIn; }

/* originally authored by Nick Pettit - https://github.com/nickpettit/glide */
@-webkit-keyframes rollOut {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0) rotate3d(0, 0, 1, 120deg);
    transform: translate3d(100%, 0, 0) rotate3d(0, 0, 1, 120deg); } }
@keyframes rollOut {
  from {
    opacity: 1; }
  to {
    opacity: 0;
    -webkit-transform: translate3d(100%, 0, 0) rotate3d(0, 0, 1, 120deg);
    transform: translate3d(100%, 0, 0) rotate3d(0, 0, 1, 120deg); } }
.rollOut {
  -webkit-animation-name: rollOut;
  animation-name: rollOut; }

@-webkit-keyframes zoomIn {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  50% {
    opacity: 1; } }
@keyframes zoomIn {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  50% {
    opacity: 1; } }
.zoomIn {
  -webkit-animation-name: zoomIn;
  animation-name: zoomIn; }

@-webkit-keyframes zoomInDown {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -1000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -1000px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomInDown {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -1000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -1000px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomInDown {
  -webkit-animation-name: zoomInDown;
  animation-name: zoomInDown; }

@-webkit-keyframes zoomInLeft {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(-1000px, 0, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(-1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(10px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomInLeft {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(-1000px, 0, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(-1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(10px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomInLeft {
  -webkit-animation-name: zoomInLeft;
  animation-name: zoomInLeft; }

@-webkit-keyframes zoomInRight {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(1000px, 0, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(-10px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(-10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomInRight {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(1000px, 0, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(1000px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(-10px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(-10px, 0, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomInRight {
  -webkit-animation-name: zoomInRight;
  animation-name: zoomInRight; }

@-webkit-keyframes zoomInUp {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 1000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 1000px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomInUp {
  from {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 1000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 1000px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  60% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomInUp {
  -webkit-animation-name: zoomInUp;
  animation-name: zoomInUp; }

@-webkit-keyframes zoomOut {
  from {
    opacity: 1; }
  50% {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  to {
    opacity: 0; } }
@keyframes zoomOut {
  from {
    opacity: 1; }
  50% {
    opacity: 0;
    -webkit-transform: scale3d(0.3, 0.3, 0.3);
    transform: scale3d(0.3, 0.3, 0.3); }
  to {
    opacity: 0; } }
.zoomOut {
  -webkit-animation-name: zoomOut;
  animation-name: zoomOut; }

@-webkit-keyframes zoomOutDown {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 2000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 2000px, 0);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomOutDown {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, -60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 2000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, 2000px, 0);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomOutDown {
  -webkit-animation-name: zoomOutDown;
  animation-name: zoomOutDown; }

@-webkit-keyframes zoomOutLeft {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(42px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(42px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: scale(0.1) translate3d(-2000px, 0, 0);
    transform: scale(0.1) translate3d(-2000px, 0, 0);
    -webkit-transform-origin: left center;
    transform-origin: left center; } }
@keyframes zoomOutLeft {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(42px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(42px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: scale(0.1) translate3d(-2000px, 0, 0);
    transform: scale(0.1) translate3d(-2000px, 0, 0);
    -webkit-transform-origin: left center;
    transform-origin: left center; } }
.zoomOutLeft {
  -webkit-animation-name: zoomOutLeft;
  animation-name: zoomOutLeft; }

@-webkit-keyframes zoomOutRight {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(-42px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(-42px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: scale(0.1) translate3d(2000px, 0, 0);
    transform: scale(0.1) translate3d(2000px, 0, 0);
    -webkit-transform-origin: right center;
    transform-origin: right center; } }
@keyframes zoomOutRight {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(-42px, 0, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(-42px, 0, 0); }
  to {
    opacity: 0;
    -webkit-transform: scale(0.1) translate3d(2000px, 0, 0);
    transform: scale(0.1) translate3d(2000px, 0, 0);
    -webkit-transform-origin: right center;
    transform-origin: right center; } }
.zoomOutRight {
  -webkit-animation-name: zoomOutRight;
  animation-name: zoomOutRight; }

@-webkit-keyframes zoomOutUp {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -2000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -2000px, 0);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
@keyframes zoomOutUp {
  40% {
    opacity: 1;
    -webkit-transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
  to {
    opacity: 0;
    -webkit-transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -2000px, 0);
    transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -2000px, 0);
    -webkit-transform-origin: center bottom;
    transform-origin: center bottom;
    -webkit-animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
    animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1); } }
.zoomOutUp {
  -webkit-animation-name: zoomOutUp;
  animation-name: zoomOutUp; }

@-webkit-keyframes slideInDown {
  from {
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes slideInDown {
  from {
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.slideInDown {
  -webkit-animation-name: slideInDown;
  animation-name: slideInDown; }

@-webkit-keyframes slideInLeft {
  from {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes slideInLeft {
  from {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.slideInLeft {
  -webkit-animation-name: slideInLeft;
  animation-name: slideInLeft; }

@-webkit-keyframes slideInRight {
  from {
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes slideInRight {
  from {
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.slideInRight {
  -webkit-animation-name: slideInRight;
  animation-name: slideInRight; }

@-webkit-keyframes slideInUp {
  from {
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
@keyframes slideInUp {
  from {
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
    visibility: visible; }
  to {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); } }
.slideInUp {
  -webkit-animation-name: slideInUp;
  animation-name: slideInUp; }

@-webkit-keyframes slideOutDown {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); } }
@keyframes slideOutDown {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0); } }
.slideOutDown {
  -webkit-animation-name: slideOutDown;
  animation-name: slideOutDown; }

@-webkit-keyframes slideOutLeft {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); } }
@keyframes slideOutLeft {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0); } }
.slideOutLeft {
  -webkit-animation-name: slideOutLeft;
  animation-name: slideOutLeft; }

@-webkit-keyframes slideOutRight {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); } }
@keyframes slideOutRight {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(100%, 0, 0);
    transform: translate3d(100%, 0, 0); } }
.slideOutRight {
  -webkit-animation-name: slideOutRight;
  animation-name: slideOutRight; }

@-webkit-keyframes slideOutUp {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); } }
@keyframes slideOutUp {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0); }
  to {
    visibility: hidden;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0); } }
.slideOutUp {
  -webkit-animation-name: slideOutUp;
  animation-name: slideOutUp; }

/*!
* FullCalendar v3.9.0
* Docs & License: https://fullcalendar.io/
* (c) 2018 Adam Shaw
*/
.fc {
  direction: ltr;
  text-align: left; }

.fc-rtl {
  text-align: right; }

body .fc {
  /* extra precedence to overcome jqui */
  font-size: 1em; }

/* Colors
--------------------------------------------------------------------------------------------------*/
.fc-highlight {
  /* when user is selecting cells */
  background: #bce8f1;
  opacity: .3; }

.fc-bgevent {
  /* default look for background events */
  background: #8fdf82;
  opacity: .3; }

.fc-nonbusiness {
  /* default look for non-business-hours areas */
  /* will inherit .fc-bgevent's styles */
  background: #d7d7d7; }

/* Buttons (styled <button> tags, normalized to work cross-browser)
--------------------------------------------------------------------------------------------------*/
.fc button {
  /* force height to include the border and padding */
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  /* dimensions */
  margin: 0;
  height: 2.1em;
  padding: 0 .6em;
  /* text & cursor */
  font-size: 1em;
  /* normalize */
  white-space: nowrap;
  cursor: pointer; }
  .fc button::-moz-focus-inner {
    margin: 0;
    padding: 0; }

/* Firefox has an annoying inner border */
.fc-state-default {
  /* non-theme */
  border: 1px solid; }
  .fc-state-default.fc-corner-left {
    /* non-theme */
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px; }
  .fc-state-default.fc-corner-right {
    /* non-theme */
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px; }

/* icons in buttons */
.fc button .fc-icon {
  /* non-theme */
  position: relative;
  top: -0.05em;
  /* seems to be a good adjustment across browsers */
  margin: 0 .2em;
  vertical-align: middle; }

/*
button states
borrowed from twitter bootstrap (http://twitter.github.com/bootstrap/)
*/
.fc-state-default {
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color: #333;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); }

.fc-state-hover, .fc-state-down, .fc-state-active, .fc-state-disabled {
  color: #333333;
  background-color: #e6e6e6; }

.fc-state-hover {
  color: #333333;
  text-decoration: none;
  background-position: 0 -15px;
  -webkit-transition: background-position 0.1s linear;
  -moz-transition: background-position 0.1s linear;
  -o-transition: background-position 0.1s linear;
  transition: background-position 0.1s linear; }

.fc-state-down, .fc-state-active {
  background-color: #cccccc;
  background-image: none;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05); }

.fc-state-disabled {
  cursor: default;
  background-image: none;
  opacity: 0.65;
  box-shadow: none; }

/* Buttons Groups
--------------------------------------------------------------------------------------------------*/
.fc-button-group {
  display: inline-block; }

/*
every button that is not first in a button group should scootch over one pixel and cover the
previous button's border...
*/
.fc .fc-button-group > * {
  /* extra precedence b/c buttons have margin set to zero */
  float: left;
  margin: 0 0 0 -1px; }
.fc .fc-button-group > :first-child {
  /* same */
  margin-left: 0; }

/* Popover
--------------------------------------------------------------------------------------------------*/
.fc-popover {
  position: absolute;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); }
  .fc-popover .fc-header {
    /* TODO: be more consistent with fc-head/fc-body */
    padding: 2px 4px; }
    .fc-popover .fc-header .fc-title {
      margin: 0 2px; }
    .fc-popover .fc-header .fc-close {
      cursor: pointer; }

.fc-ltr .fc-popover .fc-header .fc-title {
  float: left; }

.fc-rtl .fc-popover .fc-header .fc-close {
  float: left; }
.fc-rtl .fc-popover .fc-header .fc-title {
  float: right; }

.fc-ltr .fc-popover .fc-header .fc-close {
  float: right; }

/* Misc Reusable Components
--------------------------------------------------------------------------------------------------*/
.fc-divider {
  border-style: solid;
  border-width: 1px; }

hr.fc-divider {
  height: 0;
  margin: 0;
  padding: 0 0 2px;
  /* height is unreliable across browsers, so use padding */
  border-width: 1px 0; }

.fc-clear {
  clear: both; }

.fc-bg, .fc-bgevent-skeleton, .fc-highlight-skeleton, .fc-helper-skeleton {
  /* these element should always cling to top-left/right corners */
  position: absolute;
  top: 0;
  left: 0;
  right: 0; }

.fc-bg {
  bottom: 0;
  /* strech bg to bottom edge */ }
  .fc-bg table {
    height: 100%;
    /* strech bg to bottom edge */ }

/* Tables
--------------------------------------------------------------------------------------------------*/
.fc table {
  width: 100%;
  box-sizing: border-box;
  /* fix scrollbar issue in firefox */
  table-layout: fixed;
  border-collapse: collapse;
  border-spacing: 0;
  font-size: 1em;
  /* normalize cross-browser */ }
.fc th {
  text-align: center;
  border-style: solid;
  border-width: 1px;
  padding: 0;
  vertical-align: top; }
.fc td {
  border-style: solid;
  border-width: 1px;
  padding: 0;
  vertical-align: top; }
  .fc td.fc-today {
    border-style: double;
    /* overcome neighboring borders */ }

/* Internal Nav Links
--------------------------------------------------------------------------------------------------*/
a[data-goto] {
  cursor: pointer; }
  a[data-goto]:hover {
    text-decoration: underline; }

/* Fake Table Rows
--------------------------------------------------------------------------------------------------*/
.fc .fc-row {
  /* extra precedence to overcome themes w/ .ui-widget-content forcing a 1px border */
  /* no visible border by default. but make available if need be (scrollbar width compensation) */
  border-style: solid;
  border-width: 0; }

.fc-row {
  position: relative; }
  .fc-row table {
    /* don't put left/right border on anything within a fake row.
    the outer tbody will worry about this */
    border-left: 0 hidden transparent;
    border-right: 0 hidden transparent;
    /* no bottom borders on rows */
    border-bottom: 0 hidden transparent; }
  .fc-row:first-child table {
    border-top: 0 hidden transparent;
    /* no top border on first row */ }
  .fc-row .fc-bg {
    z-index: 1; }
  .fc-row .fc-bgevent-skeleton, .fc-row .fc-highlight-skeleton {
    bottom: 0;
    /* stretch skeleton to bottom of row */ }
  .fc-row .fc-bgevent-skeleton table {
    height: 100%;
    /* stretch skeleton to bottom of row */ }
  .fc-row .fc-highlight-skeleton table {
    height: 100%;
    /* stretch skeleton to bottom of row */ }
  .fc-row .fc-highlight-skeleton td {
    border-color: transparent; }
  .fc-row .fc-bgevent-skeleton {
    z-index: 2; }
    .fc-row .fc-bgevent-skeleton td {
      border-color: transparent; }
  .fc-row .fc-highlight-skeleton {
    z-index: 3; }
  .fc-row .fc-content-skeleton {
    position: relative;
    z-index: 4;
    padding-bottom: 2px;
    /* matches the space above the events */ }
  .fc-row .fc-helper-skeleton {
    z-index: 5; }

/* Day Row (used within the header and the DayGrid)
--------------------------------------------------------------------------------------------------*/
/* highlighting cells & background event skeleton */
/*
row content (which contains day/week numbers and events) as well as "helper" (which contains
temporary rendered events).
*/
.fc .fc-row .fc-content-skeleton table, .fc .fc-row .fc-content-skeleton td {
  /* see-through to the background below */
  /* extra precedence to prevent theme-provided backgrounds */
  background: none;
  /* in case <td>s are globally styled */
  border-color: transparent; }
.fc .fc-row .fc-helper-skeleton td {
  /* see-through to the background below */
  /* extra precedence to prevent theme-provided backgrounds */
  background: none;
  /* in case <td>s are globally styled */
  border-color: transparent; }

.fc-row .fc-content-skeleton td, .fc-row .fc-helper-skeleton td {
  /* don't put a border between events and/or the day number */
  border-bottom: 0; }
.fc-row .fc-content-skeleton tbody td, .fc-row .fc-helper-skeleton tbody td {
  /* don't put a border between event cells */
  border-top: 0; }

/* Scrolling Container
--------------------------------------------------------------------------------------------------*/
.fc-scroller {
  -webkit-overflow-scrolling: touch; }
  .fc-scroller > .fc-day-grid, .fc-scroller > .fc-time-grid {
    position: relative;
    /* re-scope all positions */
    width: 100%;
    /* hack to force re-sizing this inner element when scrollbars appear/disappear */ }

/* TODO: move to agenda/basic */
/* Global Event Styles
--------------------------------------------------------------------------------------------------*/
.fc-event {
  position: relative;
  /* for resize handle and other inner positioning */
  display: block;
  /* make the <a> tag block */
  font-size: .85em;
  line-height: 1.3;
  border-radius: 3px;
  background: #ffffff;
  border: 1px solid #eee;
  -webkit-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
  -moz-box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08);
  box-shadow: 0px 1px 15px 1px rgba(69, 65, 78, 0.08); }
  .fc-event .fc-content {
    padding: 0.55rem 0.55rem 0.55rem 2rem;
    color: #333; }
  .fc-event .fc-content:before {
    display: block;
    content: " ";
    position: absolute;
    height: 10px;
    width: 10px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    top: 0.7rem;
    left: 0.75rem; }
  .fc-event .fc-bg {
    background: transparent !important; }

.fc-event-dot {
  background-color: #3a87ad;
  /* default BACKGROUND color */ }

.fc-event {
  color: #ffffff;
  /* default TEXT color */
  text-decoration: none;
  /* if <a> has an href */ }
  .fc-event:hover {
    color: #ffffff;
    /* default TEXT color */
    text-decoration: none;
    /* if <a> has an href */ }
  .fc-event[href], .fc-event.fc-draggable {
    cursor: pointer;
    /* give events with links and draggable events a hand mouse pointer */ }
  .fc-event.fc-black .fc-content:before {
    background: #1a2035 !important;
    border-color: #1a2035 !important; }
  .fc-event.fc-primary .fc-content:before {
    background: #1572E8 !important;
    border-color: #1572E8 !important; }
  .fc-event.fc-secondary .fc-content:before {
    background: #6861CE !important;
    border-color: #6861CE !important; }
  .fc-event.fc-info .fc-content:before {
    background: #48ABF7 !important;
    border-color: #48ABF7 !important; }
  .fc-event.fc-success .fc-content:before {
    background: #31CE36 !important;
    border-color: #31CE36 !important; }
  .fc-event.fc-warning .fc-content:before {
    background: #FFAD46 !important;
    border-color: #FFAD46 !important; }
  .fc-event.fc-danger .fc-content:before {
    background: #F25961 !important;
    border-color: #F25961 !important; }
  .fc-event.fc-black-solid .fc-content:before, .fc-event.fc-primary-solid .fc-content:before, .fc-event.fc-secondary-solid .fc-content:before, .fc-event.fc-info-solid .fc-content:before, .fc-event.fc-success-solid .fc-content:before, .fc-event.fc-warning-solid .fc-content:before, .fc-event.fc-danger-solid .fc-content:before {
    display: none; }
  .fc-event.fc-black-solid .fc-content, .fc-event.fc-primary-solid .fc-content, .fc-event.fc-secondary-solid .fc-content, .fc-event.fc-info-solid .fc-content, .fc-event.fc-success-solid .fc-content, .fc-event.fc-warning-solid .fc-content, .fc-event.fc-danger-solid .fc-content {
    color: #ffffff;
    padding: 0.55rem 0.55rem; }
  .fc-event.fc-black-solid {
    background: #1a2035 !important;
    border-color: #1a2035 !important; }
  .fc-event.fc-primary-solid {
    background: #1572E8 !important;
    border-color: #1572E8 !important; }
  .fc-event.fc-secondary-solid {
    background: #6861CE !important;
    border-color: #6861CE !important; }
  .fc-event.fc-info-solid {
    background: #48ABF7 !important;
    border-color: #48ABF7 !important; }
  .fc-event.fc-success-solid {
    background: #31CE36 !important;
    border-color: #31CE36 !important; }
  .fc-event.fc-warning-solid {
    background: #FFAD46 !important;
    border-color: #FFAD46 !important; }
  .fc-event.fc-danger-solid {
    background: #F25961 !important;
    border-color: #F25961 !important; }

.fc-list-item.fc-black .fc-event-dot, .fc-list-item.fc-black-solid .fc-event-dot {
  background: #1a2035 !important; }
.fc-list-item.fc-primary .fc-event-dot, .fc-list-item.fc-primary-solid .fc-event-dot {
  background: #1572E8 !important; }
.fc-list-item.fc-secondary .fc-event-dot, .fc-list-item.fc-secondary-solid .fc-event-dot {
  background: #6861CE !important; }
.fc-list-item.fc-info .fc-event-dot, .fc-list-item.fc-info-solid .fc-event-dot {
  background: #48ABF7 !important; }
.fc-list-item.fc-success .fc-event-dot, .fc-list-item.fc-success-solid .fc-event-dot {
  background: #31CE36 !important; }
.fc-list-item.fc-danger .fc-event-dot, .fc-list-item.danger-solid .fc-event-dot {
  background: #F25961 !important; }
.fc-list-item.fc-danger .fc-event-dot, .fc-list-item.fc-warning-solid .fc-event-dot {
  background: #FFAD46 !important; }

.fc-widget-content {
  cursor: pointer; }

.fc-not-allowed {
  /* to override an event's custom cursor */
  cursor: not-allowed; }
  .fc-not-allowed .fc-event {
    /* to override an event's custom cursor */
    cursor: not-allowed; }

.fc-event .fc-bg {
  /* the generic .fc-bg already does position */
  z-index: 1;
  background: #ffffff;
  opacity: .25; }
.fc-event .fc-content {
  position: relative;
  z-index: 2; }
.fc-event .fc-resizer {
  position: absolute;
  z-index: 4;
  display: none; }
.fc-event.fc-allow-mouse-resize .fc-resizer {
  /* only show when hovering or selected (with touch) */
  display: block; }
.fc-event.fc-selected {
  z-index: 9999 !important;
  /* overcomes inline z-index */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); }
  .fc-event.fc-selected .fc-resizer {
    /* only show when hovering or selected (with touch) */
    display: block; }
    .fc-event.fc-selected .fc-resizer:before {
      /* 40x40 touch area */
      content: "";
      position: absolute;
      z-index: 9999;
      /* user of this util can scope within a lower z-index */
      top: 50%;
      left: 50%;
      width: 40px;
      height: 40px;
      margin-left: -20px;
      margin-top: -20px; }
  .fc-event.fc-selected.fc-dragging {
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.3); }

/* resizer (cursor AND touch devices) */
/* resizer (touch devices) */
/* hit area */
/* Event Selection (only for touch devices)
--------------------------------------------------------------------------------------------------*/
/* Horizontal Events
--------------------------------------------------------------------------------------------------*/
/* bigger touch area when selected */
.fc-h-event.fc-selected:before {
  content: "";
  position: absolute;
  z-index: 3;
  /* below resizers */
  top: -10px;
  bottom: -10px;
  left: 0;
  right: 0; }

/* events that are continuing to/from another week. kill rounded corners and butt up against edge */
.fc-ltr .fc-h-event.fc-not-start, .fc-rtl .fc-h-event.fc-not-end {
  margin-left: 0;
  border-left-width: 0;
  padding-left: 1px;
  /* replace the border with padding */
  border-top-left-radius: 0;
  border-bottom-left-radius: 0; }

.fc-ltr .fc-h-event.fc-not-end, .fc-rtl .fc-h-event.fc-not-start {
  margin-right: 0;
  border-right-width: 0;
  padding-right: 1px;
  /* replace the border with padding */
  border-top-right-radius: 0;
  border-bottom-right-radius: 0; }

/* resizer (cursor AND touch devices) */
/* left resizer  */
.fc-ltr .fc-h-event .fc-start-resizer, .fc-rtl .fc-h-event .fc-end-resizer {
  cursor: w-resize;
  left: -1px;
  /* overcome border */ }

/* right resizer */
.fc-ltr .fc-h-event .fc-end-resizer, .fc-rtl .fc-h-event .fc-start-resizer {
  cursor: e-resize;
  right: -1px;
  /* overcome border */ }

/* resizer (mouse devices) */
.fc-h-event.fc-allow-mouse-resize .fc-resizer {
  width: 7px;
  top: -1px;
  /* overcome top border */
  bottom: -1px;
  /* overcome bottom border */ }
.fc-h-event.fc-selected .fc-resizer {
  /* 8x8 little dot */
  border-radius: 4px;
  border-width: 1px;
  width: 6px;
  height: 6px;
  border-style: solid;
  border-color: inherit;
  background: #ffffff;
  /* vertically center */
  top: 50%;
  margin-top: -4px; }

/* resizer (touch devices) */
/* left resizer  */
.fc-ltr .fc-h-event.fc-selected .fc-start-resizer, .fc-rtl .fc-h-event.fc-selected .fc-end-resizer {
  margin-left: -4px;
  /* centers the 8x8 dot on the left edge */ }

/* right resizer */
.fc-ltr .fc-h-event.fc-selected .fc-end-resizer, .fc-rtl .fc-h-event.fc-selected .fc-start-resizer {
  margin-right: -4px;
  /* centers the 8x8 dot on the right edge */ }

/* DayGrid events
----------------------------------------------------------------------------------------------------
We use the full "fc-day-grid-event" class instead of using descendants because the event won't
be a descendant of the grid when it is being dragged.
*/
.fc-day-grid-event {
  margin: 1px 2px 0;
  /* spacing between events and edges */
  padding: 0 1px; }

tr:first-child > td > .fc-day-grid-event {
  margin-top: 2px;
  /* a little bit more space before the first event */ }

.fc-day-grid-event.fc-selected:after {
  content: "";
  position: absolute;
  z-index: 1;
  /* same z-index as fc-bg, behind text */
  /* overcome the borders */
  top: -1px;
  right: -1px;
  bottom: -1px;
  left: -1px;
  /* darkening effect */
  background: #000;
  opacity: .25; }
.fc-day-grid-event .fc-content {
  /* force events to be one-line tall */
  white-space: nowrap;
  overflow: hidden; }
.fc-day-grid-event .fc-time {
  font-weight: bold; }

/* resizer (cursor devices) */
/* left resizer  */
.fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer, .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer {
  margin-left: -2px;
  /* to the day cell's edge */ }

/* right resizer */
.fc-ltr .fc-day-grid-event.fc-allow-mouse-resize .fc-end-resizer, .fc-rtl .fc-day-grid-event.fc-allow-mouse-resize .fc-start-resizer {
  margin-right: -2px;
  /* to the day cell's edge */ }

/* Event Limiting
--------------------------------------------------------------------------------------------------*/
/* "more" link that represents hidden events */
a.fc-more {
  margin: 1px 3px;
  font-size: .85em;
  cursor: pointer;
  text-decoration: none; }
  a.fc-more:hover {
    text-decoration: underline; }

.fc-limited {
  /* rows and cells that are hidden because of a "more" link */
  display: none; }

/* popover that appears when "more" link is clicked */
.fc-day-grid .fc-row {
  z-index: 1;
  /* make the "more" popover one higher than this */ }

.fc-more-popover {
  z-index: 2;
  width: 220px; }
  .fc-more-popover .fc-event-container {
    padding: 10px; }

/* Now Indicator
--------------------------------------------------------------------------------------------------*/
.fc-now-indicator {
  position: absolute;
  border: 0 solid red; }

/* Utilities
--------------------------------------------------------------------------------------------------*/
.fc-unselectable {
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-touch-callout: none;
  -webkit-tap-highlight-color: transparent; }

/*
TODO: more distinction between this file and common.css
*/
/* Colors
--------------------------------------------------------------------------------------------------*/
.fc-unthemed th, .fc-unthemed td, .fc-unthemed thead, .fc-unthemed tbody, .fc-unthemed .fc-divider, .fc-unthemed .fc-row, .fc-unthemed .fc-content, .fc-unthemed .fc-popover, .fc-unthemed .fc-list-view, .fc-unthemed .fc-list-heading td {
  border-color: #ddd; }
.fc-unthemed .fc-popover {
  background-color: #ffffff; }
.fc-unthemed .fc-divider, .fc-unthemed .fc-popover .fc-header, .fc-unthemed .fc-list-heading td {
  background: #eee; }
.fc-unthemed .fc-popover .fc-header .fc-close {
  color: #666; }
.fc-unthemed td.fc-today {
  background: #fcf8e3; }
.fc-unthemed .fc-disabled-day {
  background: #d7d7d7;
  opacity: .3; }

/* Icons (inline elements with styled text that mock arrow icons)
--------------------------------------------------------------------------------------------------*/
.fc-icon {
  display: inline-block;
  height: 1em;
  line-height: 1em;
  font-size: 1em;
  text-align: center;
  overflow: hidden;
  font-family: "Courier New", Courier, monospace;
  /* don't allow browser text-selection */
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
  .fc-icon:after {
    position: relative; }

/*
Acceptable font-family overrides for individual icons:
"Arial", sans-serif
"Times New Roman", serif

NOTE: use percentage font sizes or else old IE chokes
*/
.fc-icon-left-single-arrow:after {
  content: "\2039";
  font-weight: bold;
  font-size: 200%;
  top: -7%; }

.fc-icon-right-single-arrow:after {
  content: "\203A";
  font-weight: bold;
  font-size: 200%;
  top: -7%; }

.fc-icon-left-double-arrow:after {
  content: "\AB";
  font-size: 160%;
  top: -7%; }

.fc-icon-right-double-arrow:after {
  content: "\BB";
  font-size: 160%;
  top: -7%; }

.fc-icon-left-triangle:after {
  content: "\25C4";
  font-size: 125%;
  top: 3%; }

.fc-icon-right-triangle:after {
  content: "\25BA";
  font-size: 125%;
  top: 3%; }

.fc-icon-down-triangle:after {
  content: "\25BC";
  font-size: 125%;
  top: 2%; }

.fc-icon-x:after {
  content: "\D7";
  font-size: 200%;
  top: 6%; }

/* Popover
--------------------------------------------------------------------------------------------------*/
.fc-unthemed .fc-popover {
  border-width: 1px;
  border-style: solid; }
  .fc-unthemed .fc-popover .fc-header .fc-close {
    font-size: .9em;
    margin-top: 2px; }
.fc-unthemed .fc-list-item:hover td {
  background-color: #f5f5f5; }

/* List View
--------------------------------------------------------------------------------------------------*/
/* Colors
--------------------------------------------------------------------------------------------------*/
.ui-widget .fc-disabled-day {
  background-image: none; }

/* Popover
--------------------------------------------------------------------------------------------------*/
.fc-popover > .ui-widget-header + .ui-widget-content {
  border-top: 0;
  /* where they meet, let the header have the border */ }

/* Global Event Styles
--------------------------------------------------------------------------------------------------*/
.ui-widget .fc-event {
  /* overpower jqui's styles on <a> tags. TODO: more DRY */
  color: #ffffff;
  /* default TEXT color */
  text-decoration: none;
  /* if <a> has an href */
  /* undo ui-widget-header bold */
  font-weight: normal; }
.ui-widget td.fc-axis {
  font-weight: normal;
  /* overcome bold */ }

/* TimeGrid axis running down the side (for both the all-day area and the slot area)
--------------------------------------------------------------------------------------------------*/
/* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
.fc-time-grid .fc-slats .ui-widget-content {
  background: none;
  /* see through to fc-bg */ }

.fc.fc-bootstrap3 a {
  text-decoration: none; }
  .fc.fc-bootstrap3 a[data-goto]:hover {
    text-decoration: underline; }

.fc-bootstrap3 hr.fc-divider {
  border-color: inherit; }
.fc-bootstrap3 .fc-today.alert {
  border-radius: 0; }
.fc-bootstrap3 .fc-popover .panel-body {
  padding: 0; }
.fc-bootstrap3 .fc-time-grid .fc-slats table {
  /* some themes have background color. see through to slats */
  background: none; }

/* Popover
--------------------------------------------------------------------------------------------------*/
/* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
.fc.fc-bootstrap4 a {
  text-decoration: none; }
  .fc.fc-bootstrap4 a[data-goto]:hover {
    text-decoration: underline; }

.fc-bootstrap4 hr.fc-divider {
  border-color: inherit; }
.fc-bootstrap4 .fc-today.alert {
  border-radius: 0; }
.fc-bootstrap4 a.fc-event:not([href]):not([tabindex]) {
  color: #ffffff; }
.fc-bootstrap4 .fc-popover.card {
  position: absolute; }
.fc-bootstrap4 .fc-popover .card-body {
  padding: 0; }
.fc-bootstrap4 .fc-time-grid .fc-slats table {
  /* some themes have background color. see through to slats */
  background: none; }

/* Popover
--------------------------------------------------------------------------------------------------*/
/* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
/* Toolbar
--------------------------------------------------------------------------------------------------*/
.fc-toolbar {
  text-align: center; }
  .fc-toolbar .fc-button {
    background: #f4f5f8;
    border: 0;
    text-shadow: none !important;
    padding: 8px 12px;
    height: auto;
    font-size: 1.04em; }
    .fc-toolbar .fc-button:hover {
      background: #eee; }
  .fc-toolbar h2 {
    font-size: 1.2rem;
    font-weight: 400;
    text-transform: uppercase;
    margin-top: 0.75rem; }
  .fc-toolbar.fc-header-toolbar {
    margin-bottom: 1em; }
  .fc-toolbar.fc-footer-toolbar {
    margin-top: 1em; }
  .fc-toolbar .fc-left {
    float: left; }
  .fc-toolbar .fc-right {
    float: right; }
  .fc-toolbar .fc-center {
    display: inline-block; }
  .fc-toolbar .fc-state-active {
    background: #1d7af3;
    color: #ffffff;
    box-shadow: none !important; }
    .fc-toolbar .fc-state-active:hover {
      background: #1d7af3; }

/* the things within each left/right/center section */
.fc .fc-toolbar > * > * {
  /* extra precedence to override button border margins */
  float: left;
  margin-left: .75em; }
.fc .fc-toolbar > * > :first-child {
  /* extra precedence to override button border margins */
  margin-left: 0; }

/* the first thing within each left/center/right section */
/* title text */
.fc-toolbar h2 {
  margin: 0; }
.fc-toolbar button {
  position: relative; }
.fc-toolbar .fc-state-hover, .fc-toolbar .ui-state-hover {
  z-index: 2; }
.fc-toolbar .fc-state-down {
  z-index: 3; }
.fc-toolbar .fc-state-active, .fc-toolbar .ui-state-active {
  z-index: 4; }
.fc-toolbar button:focus {
  z-index: 5; }

/* button layering (for border precedence) */
/* View Structure
--------------------------------------------------------------------------------------------------*/
/* undo twitter bootstrap's box-sizing rules. normalizes positioning techniques */
/* don't do this for the toolbar because we'll want bootstrap to style those buttons as some pt */
.fc-view-container * {
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box; }
  .fc-view-container *:before, .fc-view-container *:after {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box; }

.fc-view {
  /* so dragged elements can be above the view's main element */
  position: relative;
  z-index: 1; }
  .fc-view > table {
    /* so dragged elements can be above the view's main element */
    position: relative;
    z-index: 1; }

/* BasicView
--------------------------------------------------------------------------------------------------*/
/* day row structure */
.fc-basicWeek-view .fc-content-skeleton, .fc-basicDay-view .fc-content-skeleton {
  /* there may be week numbers in these views, so no padding-top */
  padding-bottom: 1em;
  /* ensure a space at bottom of cell for user selecting/clicking */ }

.fc-basic-view .fc-body .fc-row {
  min-height: 4em;
  /* ensure that all rows are at least this tall */ }

/* a "rigid" row will take up a constant amount of height because content-skeleton is absolute */
.fc-row.fc-rigid {
  overflow: hidden; }
  .fc-row.fc-rigid .fc-content-skeleton {
    position: absolute;
    top: 0;
    left: 0;
    right: 0; }

/* week and day number styling */
.fc-day-top.fc-other-month {
  opacity: 0.3; }

.fc-basic-view .fc-week-number, .fc-basic-view .fc-day-number {
  padding: 2px; }
.fc-basic-view th.fc-week-number, .fc-basic-view th.fc-day-number {
  padding: 0 2px;
  /* column headers can't have as much v space */ }

.fc-ltr .fc-basic-view .fc-day-top .fc-day-number {
  float: right; }

.fc-rtl .fc-basic-view .fc-day-top .fc-day-number {
  float: left; }

.fc-ltr .fc-basic-view .fc-day-top .fc-week-number {
  float: left;
  border-radius: 0 0 3px 0; }

.fc-rtl .fc-basic-view .fc-day-top .fc-week-number {
  float: right;
  border-radius: 0 0 0 3px; }

.fc-basic-view .fc-day-top .fc-week-number {
  min-width: 1.5em;
  text-align: center;
  background-color: #f2f2f2;
  color: #808080; }
.fc-basic-view td.fc-week-number {
  text-align: center; }
  .fc-basic-view td.fc-week-number > * {
    /* work around the way we do column resizing and ensure a minimum width */
    display: inline-block;
    min-width: 1.25em; }

/* when week/day number have own column */
/* AgendaView all-day area
--------------------------------------------------------------------------------------------------*/
.fc-agenda-view .fc-day-grid {
  position: relative;
  z-index: 2;
  /* so the "more.." popover will be over the time grid */ }
  .fc-agenda-view .fc-day-grid .fc-row {
    min-height: 3em;
    /* all-day section will never get shorter than this */ }
    .fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
      padding-bottom: 1em;
      /* give space underneath events for clicking/selecting days */ }

/* TimeGrid axis running down the side (for both the all-day area and the slot area)
--------------------------------------------------------------------------------------------------*/
.fc .fc-axis {
  /* .fc to overcome default cell styles */
  vertical-align: middle;
  padding: 0 4px;
  white-space: nowrap; }

.fc-ltr .fc-axis {
  text-align: right; }

.fc-rtl .fc-axis {
  text-align: left; }

/* TimeGrid Structure
--------------------------------------------------------------------------------------------------*/
.fc-time-grid-container {
  /* so slats/bg/content/etc positions get scoped within here */
  position: relative;
  z-index: 1; }

.fc-time-grid {
  /* so slats/bg/content/etc positions get scoped within here */
  position: relative;
  z-index: 1;
  min-height: 100%;
  /* so if height setting is 'auto', .fc-bg stretches to fill height */ }
  .fc-time-grid table {
    /* don't put outer borders on slats/bg/content/etc */
    border: 0 hidden transparent; }
  .fc-time-grid > .fc-bg {
    z-index: 1; }
  .fc-time-grid .fc-slats, .fc-time-grid > hr {
    /* the <hr> AgendaView injects when grid is shorter than scroller */
    position: relative;
    z-index: 2; }
  .fc-time-grid .fc-content-col {
    position: relative;
    /* because now-indicator lives directly inside */ }
  .fc-time-grid .fc-content-skeleton {
    position: absolute;
    z-index: 3;
    top: 0;
    left: 0;
    right: 0; }
  .fc-time-grid .fc-business-container {
    position: relative;
    z-index: 1; }
  .fc-time-grid .fc-bgevent-container {
    position: relative;
    z-index: 2; }
  .fc-time-grid .fc-highlight-container {
    position: relative;
    z-index: 3; }
  .fc-time-grid .fc-event-container {
    position: relative;
    z-index: 4; }
  .fc-time-grid .fc-now-indicator-line {
    z-index: 5; }
  .fc-time-grid .fc-helper-container {
    /* also is fc-event-container */
    position: relative;
    z-index: 6; }
  .fc-time-grid .fc-slats td {
    height: 1.5em;
    border-bottom: 0;
    /* each cell is responsible for its top border */ }
  .fc-time-grid .fc-slats .fc-minor td {
    border-top-style: dotted; }
  .fc-time-grid .fc-highlight-container {
    /* a div within a cell within the fc-highlight-skeleton */
    position: relative;
    /* scopes the left/right of the fc-highlight to be in the column */ }
  .fc-time-grid .fc-highlight {
    position: absolute;
    left: 0;
    right: 0;
    /* top and bottom will be in by JS */ }

/* divs within a cell within the fc-state-style-skeleton */
/* TimeGrid Slats (lines that run horizontally)
--------------------------------------------------------------------------------------------------*/
/* TimeGrid Highlighting Slots
--------------------------------------------------------------------------------------------------*/
/* TimeGrid Event Containment
--------------------------------------------------------------------------------------------------*/
.fc-ltr .fc-time-grid .fc-event-container {
  /* space on the sides of events for LTR (default) */
  margin: 0 2.5% 0 2px; }

.fc-rtl .fc-time-grid .fc-event-container {
  /* space on the sides of events for RTL */
  margin: 0 2px 0 2.5%; }

.fc-time-grid .fc-event {
  position: absolute;
  z-index: 1;
  /* scope inner z-index's */ }
.fc-time-grid .fc-bgevent {
  position: absolute;
  z-index: 1;
  /* scope inner z-index's */
  /* background events always span full width */
  left: 0;
  right: 0; }

/* Generic Vertical Event
--------------------------------------------------------------------------------------------------*/
.fc-v-event.fc-not-start {
  /* events that are continuing from another day */
  /* replace space made by the top border with padding */
  border-top-width: 0;
  padding-top: 1px;
  /* remove top rounded corners */
  border-top-left-radius: 0;
  border-top-right-radius: 0; }
.fc-v-event.fc-not-end {
  /* replace space made by the top border with padding */
  border-bottom-width: 0;
  padding-bottom: 1px;
  /* remove bottom rounded corners */
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0; }

/* TimeGrid Event Styling
----------------------------------------------------------------------------------------------------
We use the full "fc-time-grid-event" class instead of using descendants because the event won't
be a descendant of the grid when it is being dragged.
*/
.fc-time-grid-event {
  overflow: hidden;
  /* don't let the bg flow over rounded corners */ }
  .fc-time-grid-event.fc-selected {
    /* need to allow touch resizers to extend outside event's bounding box */
    /* common fc-selected styles hide the fc-bg, so don't need this anyway */
    overflow: visible; }
    .fc-time-grid-event.fc-selected .fc-bg {
      display: none;
      /* hide semi-white background, to appear darker */ }
  .fc-time-grid-event .fc-content {
    overflow: hidden;
    /* for when .fc-selected */ }
  .fc-time-grid-event .fc-time, .fc-time-grid-event .fc-title {
    padding: 0 1px; }
  .fc-time-grid-event .fc-time {
    font-size: .85em;
    white-space: nowrap; }
  .fc-time-grid-event.fc-short .fc-content {
    /* don't wrap to second line (now that contents will be inline) */
    white-space: nowrap; }
  .fc-time-grid-event.fc-short .fc-time, .fc-time-grid-event.fc-short .fc-title {
    /* put the time and title on the same line */
    display: inline-block;
    vertical-align: top; }
  .fc-time-grid-event.fc-short .fc-time span {
    display: none;
    /* don't display the full time text... */ }
  .fc-time-grid-event.fc-short .fc-time:before {
    content: attr(data-start);
    /* ...instead, display only the start time */ }
  .fc-time-grid-event.fc-short .fc-time:after {
    content: "\A0-\A0";
    /* seperate with a dash, wrapped in nbsp's */ }
  .fc-time-grid-event.fc-short .fc-title {
    font-size: .85em;
    /* make the title text the same size as the time */
    padding: 0;
    /* undo padding from above */ }
  .fc-time-grid-event.fc-allow-mouse-resize .fc-resizer {
    left: 0;
    right: 0;
    bottom: 0;
    height: 8px;
    overflow: hidden;
    line-height: 8px;
    font-size: 11px;
    font-family: monospace;
    text-align: center;
    cursor: s-resize; }
    .fc-time-grid-event.fc-allow-mouse-resize .fc-resizer:after {
      content: "="; }
  .fc-time-grid-event.fc-selected .fc-resizer {
    /* 10x10 dot */
    border-radius: 5px;
    border-width: 1px;
    width: 8px;
    height: 8px;
    border-style: solid;
    border-color: inherit;
    background: #ffffff;
    /* horizontally center */
    left: 50%;
    margin-left: -5px;
    /* center on the bottom edge */
    bottom: -5px; }

/* short mode, where time and title are on the same line */
/* resizer (cursor device) */
/* resizer (touch device) */
/* Now Indicator
--------------------------------------------------------------------------------------------------*/
.fc-time-grid .fc-now-indicator-line {
  border-top-width: 1px;
  left: 0;
  right: 0; }
.fc-time-grid .fc-now-indicator-arrow {
  margin-top: -5px;
  /* vertically center on top coordinate */ }

/* arrow on axis */
.fc-ltr .fc-time-grid .fc-now-indicator-arrow {
  left: 0;
  /* triangle pointing right... */
  border-width: 5px 0 5px 6px;
  border-top-color: transparent;
  border-bottom-color: transparent; }

.fc-rtl .fc-time-grid .fc-now-indicator-arrow {
  right: 0;
  /* triangle pointing left... */
  border-width: 5px 6px 5px 0;
  border-top-color: transparent;
  border-bottom-color: transparent; }

/* List View
--------------------------------------------------------------------------------------------------*/
/* possibly reusable */
.fc-event-dot {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 5px; }

/* view wrapper */
.fc-rtl .fc-list-view {
  direction: rtl;
  /* unlike core views, leverage browser RTL */ }

.fc-list-view {
  border-width: 1px;
  border-style: solid; }

/* table resets */
.fc .fc-list-table {
  table-layout: auto;
  /* for shrinkwrapping cell content */ }

.fc-list-table td {
  border-width: 1px 0 0;
  padding: 8px 14px; }
.fc-list-table tr:first-child td {
  border-top-width: 0; }

/* day headings with the list */
.fc-list-heading {
  border-bottom-width: 1px; }
  .fc-list-heading td {
    font-weight: bold; }

.fc-ltr .fc-list-heading-main {
  float: left; }
.fc-ltr .fc-list-heading-alt {
  float: right; }

.fc-rtl .fc-list-heading-main {
  float: right; }
.fc-rtl .fc-list-heading-alt {
  float: left; }

/* event list items */
.fc-list-item.fc-has-url {
  cursor: pointer;
  /* whole row will be clickable */ }

.fc-list-item-marker, .fc-list-item-time {
  white-space: nowrap;
  width: 1px; }

/* make the dot closer to the event title */
.fc-ltr .fc-list-item-marker {
  padding-right: 0; }

.fc-rtl .fc-list-item-marker {
  padding-left: 0; }

.fc-list-item-title a {
  /* every event title cell has an <a> tag */
  text-decoration: none;
  color: inherit; }
  .fc-list-item-title a[href]:hover {
    /* hover effect only on titles with hrefs */
    text-decoration: underline; }

/* message when no events */
.fc-list-empty-wrap2 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0; }

.fc-list-empty-wrap1 {
  width: 100%;
  height: 100%;
  display: table; }

.fc-list-empty {
  display: table-cell;
  vertical-align: middle;
  text-align: center; }

.fc-unthemed .fc-list-empty {
  /* theme will provide own background */
  background-color: #eee; }

/*		Sweet Alert		*/
.swal-footer {
  text-align: center !important;
  margin-bottom: 20px !important; }

/*      Datatable     */
table.dataTable {
  clear: both;
  margin-top: 15px !important;
  margin-bottom: 15px !important;
  max-width: none !important;
  border-collapse: separate !important; }
  table.dataTable td, table.dataTable th {
    -webkit-box-sizing: content-box;
    box-sizing: content-box; }
  table.dataTable td.dataTables_empty, table.dataTable th.dataTables_empty {
    text-align: center; }
  table.dataTable.nowrap th, table.dataTable.nowrap td {
    white-space: nowrap; }

div.dataTables_wrapper div.dataTables_length label {
  font-weight: normal;
  text-align: left;
  white-space: nowrap; }
div.dataTables_wrapper div.dataTables_length select {
  width: 75px;
  display: inline-block; }
div.dataTables_wrapper div.dataTables_filter {
  text-align: right; }
  div.dataTables_wrapper div.dataTables_filter label {
    font-weight: normal;
    white-space: nowrap;
    text-align: left; }
  div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto; }
div.dataTables_wrapper div.dataTables_info {
  padding-top: 0.85em;
  white-space: nowrap; }
div.dataTables_wrapper div.dataTables_paginate {
  margin: 0;
  white-space: nowrap;
  text-align: right; }
  div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 2px 0;
    white-space: nowrap;
    justify-content: flex-end; }
div.dataTables_wrapper div.dataTables_processing {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 200px;
  margin-left: -100px;
  margin-top: -26px;
  text-align: center;
  padding: 1em 0; }

table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
  padding-right: 30px; }
table.dataTable thead > tr > th:active, table.dataTable thead > tr > td:active {
  outline: none; }
table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
  cursor: pointer;
  position: relative; }
table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
  position: absolute;
  bottom: 0.9em;
  display: block;
  opacity: 0.5; }
table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before {
  right: 1em;
  content: "\2191";
  font-size: 15px; }
table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
  right: 0.5em;
  content: "\2193";
  font-size: 15px; }
table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:after {
  opacity: 1; }
table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
  opacity: 0; }

div.dataTables_scrollHead table.dataTable {
  margin-bottom: 0 !important; }
div.dataTables_scrollBody table {
  border-top: none;
  margin-top: 0 !important;
  margin-bottom: 0 !important; }
  div.dataTables_scrollBody table thead .sorting:after, div.dataTables_scrollBody table thead .sorting_asc:after, div.dataTables_scrollBody table thead .sorting_desc:after {
    display: none; }
  div.dataTables_scrollBody table tbody tr:first-child th, div.dataTables_scrollBody table tbody tr:first-child td {
    border-top: none; }
div.dataTables_scrollFoot > .dataTables_scrollFootInner {
  box-sizing: content-box; }
  div.dataTables_scrollFoot > .dataTables_scrollFootInner > table {
    margin-top: 0 !important;
    border-top: none; }

@media screen and (max-width: 767px) {
  div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
    text-align: center;
    margin-top: 11px;
    margin-bottom: 10px; }
  div.dataTables_wrapper div div.dataTables_paginate ul.pagination {
    flex-wrap: wrap !important;
    justify-content: center !important; }
    div.dataTables_wrapper div div.dataTables_paginate ul.pagination li {
      margin-bottom: 10px; }
      div.dataTables_wrapper div div.dataTables_paginate ul.pagination li a {
        font-size: 11px; } }
table.dataTable.table-sm > thead > tr > th {
  padding-right: 20px; }
table.dataTable.table-sm .sorting:before, table.dataTable.table-sm .sorting_asc:before, table.dataTable.table-sm .sorting_desc:before {
  top: 5px;
  right: 0.85em; }
table.dataTable.table-sm .sorting:after, table.dataTable.table-sm .sorting_asc:after, table.dataTable.table-sm .sorting_desc:after {
  top: 5px; }
table.table-bordered.dataTable th, table.table-bordered.dataTable td {
  border-left-width: 0; }
table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child {
  border-right-width: 0; }
table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
  border-bottom-width: 0; }

div.dataTables_scrollHead table.table-bordered {
  border-bottom-width: 0; }
div.table-responsive > div.dataTables_wrapper > div.row {
  margin: 0; }
  div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:first-child, div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:last-child {
    padding-left: 0;
    padding-right: 0; }

/*!
 * Datetimepicker for Bootstrap 3
 * version : 4.17.47
 * https://github.com/Eonasdan/bootstrap-datetimepicker/
 */
.bootstrap-datetimepicker-widget {
  list-style: none;
  z-index: 100; }
  .bootstrap-datetimepicker-widget.dropdown-menu {
    padding: 10px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    direction: ltr;
    border: 0 !important;
    -webkit-box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    -moz-box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    font-size: 12px;
    font-weight: 400;
    margin-top: 10px !important;
    margin-bottom: 10px !important; }
  .bootstrap-datetimepicker-widget .list-unstyled {
    margin: 0; }
  .bootstrap-datetimepicker-widget a[data-action] {
    padding: 6px 0;
    font-size: 16px;
    font-weight: 800;
    color: #1572E8; }
    .bootstrap-datetimepicker-widget a[data-action]:active {
      box-shadow: none;
      color: #1572E8; }
  .bootstrap-datetimepicker-widget .timepicker-hour, .bootstrap-datetimepicker-widget .timepicker-minute, .bootstrap-datetimepicker-widget .timepicker-second {
    width: 54px;
    font-weight: bold;
    font-size: 1.2em;
    margin: 0; }
  .bootstrap-datetimepicker-widget button[data-action] {
    padding: 6px; }
  .bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Increment Hours"; }
  .bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Increment Minutes"; }
  .bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Decrement Hours"; }
  .bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Decrement Minutes"; }
  .bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Show Hours"; }
  .bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Show Minutes"; }
  .bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Toggle AM/PM"; }
  .bootstrap-datetimepicker-widget .btn[data-action="clear"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Clear the picker"; }
  .bootstrap-datetimepicker-widget .btn[data-action="today"]::after {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    content: "Set the date to today"; }
  .bootstrap-datetimepicker-widget .picker-switch {
    text-align: center; }
    .bootstrap-datetimepicker-widget .picker-switch::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Toggle Date and Time Screens"; }
    .bootstrap-datetimepicker-widget .picker-switch td {
      padding: 0;
      margin: 0;
      height: auto;
      width: auto;
      line-height: inherit; }
      .bootstrap-datetimepicker-widget .picker-switch td span {
        font-size: 16px;
        line-height: 2.5;
        height: 2.5em;
        width: 100%;
        font-weight: 800; }
  .bootstrap-datetimepicker-widget table {
    width: 100%;
    margin: 0; }
    .bootstrap-datetimepicker-widget table td, .bootstrap-datetimepicker-widget table th {
      width: 30px;
      height: 30px;
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      border-radius: 2px;
      border: none; }
    .bootstrap-datetimepicker-widget table td {
      text-align: center;
      border-radius: 3px; }
    .bootstrap-datetimepicker-widget table th {
      text-align: center;
      border-radius: 2px;
      line-height: 20px; }
      .bootstrap-datetimepicker-widget table th.picker-switch {
        width: 145px; }
      .bootstrap-datetimepicker-widget table th.disabled {
        background: none;
        color: #777;
        cursor: not-allowed; }
        .bootstrap-datetimepicker-widget table th.disabled:hover {
          background: none;
          color: #777;
          cursor: not-allowed; }
      .bootstrap-datetimepicker-widget table th.prev::after {
        position: absolute;
        width: 1px;
        height: 1px;
        margin: -1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
        content: "Previous Month"; }
      .bootstrap-datetimepicker-widget table th.next::after {
        position: absolute;
        width: 1px;
        height: 1px;
        margin: -1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
        content: "Next Month"; }
    .bootstrap-datetimepicker-widget table thead tr:first-child th {
      cursor: pointer; }
      .bootstrap-datetimepicker-widget table thead tr:first-child th:hover {
        background: #eee; }
    .bootstrap-datetimepicker-widget table td {
      height: 54px;
      line-height: 54px;
      width: 54px; }
      .bootstrap-datetimepicker-widget table td.cw {
        font-size: .8em;
        height: 20px;
        line-height: 20px;
        color: #777; }
      .bootstrap-datetimepicker-widget table td.day {
        height: 25px;
        line-height: 25px;
        width: 25px; }
        .bootstrap-datetimepicker-widget table td.day:hover {
          background: #eee;
          cursor: pointer; }
      .bootstrap-datetimepicker-widget table td.hour:hover, .bootstrap-datetimepicker-widget table td.minute:hover, .bootstrap-datetimepicker-widget table td.second:hover {
        background: #eee;
        cursor: pointer; }
      .bootstrap-datetimepicker-widget table td.old, .bootstrap-datetimepicker-widget table td.new {
        color: #777; }
      .bootstrap-datetimepicker-widget table td.today {
        position: relative; }
        .bootstrap-datetimepicker-widget table td.today:before {
          content: '';
          display: inline-block;
          border: solid transparent;
          border-width: 0 0 7px 7px;
          border-bottom-color: #1572E8;
          border-top-color: rgba(0, 0, 0, 0.2);
          position: absolute;
          bottom: 4px;
          right: 4px; }
      .bootstrap-datetimepicker-widget table td.active {
        background-color: #1572E8;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); }
        .bootstrap-datetimepicker-widget table td.active:hover {
          background-color: #1572E8;
          color: #fff;
          text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); }
        .bootstrap-datetimepicker-widget table td.active.today:before {
          border-bottom-color: #fff; }
      .bootstrap-datetimepicker-widget table td.disabled {
        background: none;
        color: #777;
        cursor: not-allowed; }
        .bootstrap-datetimepicker-widget table td.disabled:hover {
          background: none;
          color: #777;
          cursor: not-allowed; }
      .bootstrap-datetimepicker-widget table td span {
        display: inline-block;
        width: 54px;
        height: 54px;
        line-height: 54px;
        margin: 2px 1.5px;
        cursor: pointer;
        border-radius: 4px; }
        .bootstrap-datetimepicker-widget table td span:hover {
          color: #1572E8;
          background: #eee; }
        .bootstrap-datetimepicker-widget table td span.active {
          background-color: #1572E8;
          color: #fff;
          text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); }
        .bootstrap-datetimepicker-widget table td span.old {
          color: #777; }
        .bootstrap-datetimepicker-widget table td span.disabled {
          background: none;
          color: #777;
          cursor: not-allowed; }
          .bootstrap-datetimepicker-widget table td span.disabled:hover {
            background: none;
            color: #777;
            cursor: not-allowed; }
  .bootstrap-datetimepicker-widget.usetwentyfour td.hour {
    height: 27px;
    line-height: 27px; }
  .bootstrap-datetimepicker-widget .datepicker-decades .decade {
    line-height: 1.8em !important; }

.input-group.date .input-group-addon {
  cursor: pointer; }

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  margin: -1px;
  padding: 0;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  border: 0; }

/*      Select2     */
.select2-container {
  box-sizing: border-box;
  display: inline-block;
  margin: 0;
  position: relative;
  vertical-align: middle; }
  .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    user-select: none;
    -webkit-user-select: none; }
    .select2-container .select2-selection--single .select2-selection__rendered {
      display: block;
      padding-left: 8px;
      padding-right: 20px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap; }
    .select2-container .select2-selection--single .select2-selection__clear {
      position: relative; }
  .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
    padding-right: 8px;
    padding-left: 20px; }
  .select2-container .select2-selection--multiple {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    min-height: 32px;
    user-select: none;
    -webkit-user-select: none; }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
      display: inline-block;
      overflow: hidden;
      padding-left: 8px;
      text-overflow: ellipsis;
      white-space: nowrap; }
  .select2-container .select2-search--inline {
    float: left; }
    .select2-container .select2-search--inline .select2-search__field {
      box-sizing: border-box;
      border: none;
      font-size: 100%;
      margin-top: 5px;
      padding: 0; }
      .select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button {
        -webkit-appearance: none; }

.select2-dropdown {
  background-color: white;
  border: 1px solid #aaa;
  border-radius: 4px;
  box-sizing: border-box;
  display: block;
  position: absolute;
  left: -100000px;
  width: 100%;
  z-index: 1051; }

.select2-results {
  display: block; }

.select2-results__options {
  list-style: none;
  margin: 0;
  padding: 0; }

.select2-results__option {
  padding: 6px;
  user-select: none;
  -webkit-user-select: none; }
  .select2-results__option[aria-selected] {
    cursor: pointer; }

.select2-container--open .select2-dropdown {
  left: 0; }
.select2-container--open .select2-dropdown--above {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0; }
.select2-container--open .select2-dropdown--below {
  border-top: none;
  border-top-left-radius: 0;
  border-top-right-radius: 0; }

.select2-search--dropdown {
  display: block;
  padding: 5px 10px; }
  .select2-search--dropdown .select2-search__field {
    padding: 4px;
    width: 100%;
    box-sizing: border-box; }
    .select2-search--dropdown .select2-search__field::-webkit-search-cancel-button {
      -webkit-appearance: none; }
  .select2-search--dropdown.select2-search--hide {
    display: none; }

.select2-close-mask {
  border: 0;
  margin: 0;
  padding: 0;
  display: block;
  position: fixed;
  left: 0;
  top: 0;
  min-height: 100%;
  min-width: 100%;
  height: auto;
  width: auto;
  opacity: 0;
  z-index: 99;
  background-color: #ffffff;
  filter: alpha(opacity=0); }

.select2-hidden-accessible {
  border: 0 !important;
  clip: rect(0 0 0 0) !important;
  -webkit-clip-path: inset(50%) !important;
  clip-path: inset(50%) !important;
  height: 1px !important;
  overflow: hidden !important;
  padding: 0 !important;
  position: absolute !important;
  width: 1px !important;
  white-space: nowrap !important; }

.select2-container--default .select2-selection--single {
  background-color: #ffffff;
  border: 1px solid #aaa;
  border-radius: 4px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px; }
  .select2-container--default .select2-selection--single .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: bold; }
  .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #999; }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
      border-color: #888 transparent transparent transparent;
      border-style: solid;
      border-width: 5px 4px 0 4px;
      height: 0;
      left: 50%;
      margin-left: -4px;
      margin-top: -2px;
      position: absolute;
      top: 50%;
      width: 0; }
.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear {
  float: left; }
.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow {
  left: 1px;
  right: auto; }
.select2-container--default.select2-container--disabled .select2-selection--single {
  background-color: #eee;
  cursor: default; }
  .select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear {
    display: none; }
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
  border-color: transparent transparent #888 transparent;
  border-width: 0 4px 5px 4px; }
.select2-container--default .select2-selection--multiple {
  background-color: white;
  border: 1px solid #aaa;
  border-radius: 4px;
  cursor: text; }
  .select2-container--default .select2-selection--multiple .select2-selection__rendered {
    box-sizing: border-box;
    list-style: none;
    margin: 0;
    padding: 0 5px;
    width: 100%; }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
      list-style: none; }
  .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
    color: #999;
    margin-top: 5px;
    float: left; }
  .select2-container--default .select2-selection--multiple .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-top: 5px;
    margin-right: 10px; }
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px; }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #999;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #333; }
.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice, .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder, .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline {
  float: right; }
.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
  margin-left: 5px;
  margin-right: auto; }
.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
  margin-left: 2px;
  margin-right: auto; }
.select2-container--default.select2-container--focus .select2-selection--multiple {
  border: solid black 1px;
  outline: 0; }
.select2-container--default.select2-container--disabled .select2-selection--multiple {
  background-color: #eee;
  cursor: default; }
.select2-container--default.select2-container--disabled .select2-selection__choice__remove {
  display: none; }
.select2-container--default.select2-container--open.select2-container--above .select2-selection--single, .select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple {
  border-top-left-radius: 0;
  border-top-right-radius: 0; }
.select2-container--default.select2-container--open.select2-container--below .select2-selection--single, .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0; }
.select2-container--default .select2-search--dropdown .select2-search__field {
  border: 1px solid #aaa; }
.select2-container--default .select2-search--inline .select2-search__field {
  background: transparent;
  border: none;
  outline: 0;
  box-shadow: none;
  -webkit-appearance: textfield; }
.select2-container--default .select2-results > .select2-results__options {
  max-height: 200px;
  overflow-y: auto; }
.select2-container--default .select2-results__option[role=group] {
  padding: 0; }
.select2-container--default .select2-results__option[aria-disabled=true] {
  color: #999; }
.select2-container--default .select2-results__option[aria-selected=true] {
  background-color: #ddd; }
.select2-container--default .select2-results__option .select2-results__option {
  padding-left: 1em; }
  .select2-container--default .select2-results__option .select2-results__option .select2-results__group {
    padding-left: 0; }
  .select2-container--default .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -1em;
    padding-left: 2em; }
    .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
      margin-left: -2em;
      padding-left: 3em; }
      .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
        margin-left: -3em;
        padding-left: 4em; }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
          margin-left: -4em;
          padding-left: 5em; }
          .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -5em;
            padding-left: 6em; }
.select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color: #5897fb;
  color: white; }
.select2-container--default .select2-results__group {
  cursor: default;
  display: block;
  padding: 6px; }

.select2-container--classic .select2-selection--single {
  background-color: #f7f7f7;
  border: 1px solid #aaa;
  border-radius: 4px;
  outline: 0;
  background-image: -webkit-linear-gradient(top, white 50%, #eeeeee 100%);
  background-image: -o-linear-gradient(top, white 50%, #eeeeee 100%);
  background-image: linear-gradient(to bottom, white 50%, #eeeeee 100%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$white-colorFFFFF', endColorstr='#FFEEEEEE', GradientType=0); }
  .select2-container--classic .select2-selection--single:focus {
    border: 1px solid #5897fb; }
  .select2-container--classic .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px; }
  .select2-container--classic .select2-selection--single .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-right: 10px; }
  .select2-container--classic .select2-selection--single .select2-selection__placeholder {
    color: #999; }
  .select2-container--classic .select2-selection--single .select2-selection__arrow {
    background-color: #ddd;
    border: none;
    border-left: 1px solid #aaa;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    height: 26px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
    background-image: -webkit-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
    background-image: -o-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
    background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0); }
    .select2-container--classic .select2-selection--single .select2-selection__arrow b {
      border-color: #888 transparent transparent transparent;
      border-style: solid;
      border-width: 5px 4px 0 4px;
      height: 0;
      left: 50%;
      margin-left: -4px;
      margin-top: -2px;
      position: absolute;
      top: 50%;
      width: 0; }
.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__clear {
  float: left; }
.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__arrow {
  border: none;
  border-right: 1px solid #aaa;
  border-radius: 0;
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
  left: 1px;
  right: auto; }
.select2-container--classic.select2-container--open .select2-selection--single {
  border: 1px solid #5897fb; }
  .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow {
    background: transparent;
    border: none; }
    .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
      border-color: transparent transparent #888 transparent;
      border-width: 0 4px 5px 4px; }
.select2-container--classic.select2-container--open.select2-container--above .select2-selection--single {
  border-top: none;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  background-image: -webkit-linear-gradient(top, white 0%, #eeeeee 50%);
  background-image: -o-linear-gradient(top, white 0%, #eeeeee 50%);
  background-image: linear-gradient(to bottom, white 0%, #eeeeee 50%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$white-colorFFFFF', endColorstr='#FFEEEEEE', GradientType=0); }
.select2-container--classic.select2-container--open.select2-container--below .select2-selection--single {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  background-image: -webkit-linear-gradient(top, #eeeeee 50%, white 100%);
  background-image: -o-linear-gradient(top, #eeeeee 50%, white 100%);
  background-image: linear-gradient(to bottom, #eeeeee 50%, white 100%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='$white-colorFFFFF', GradientType=0); }
.select2-container--classic .select2-selection--multiple {
  background-color: white;
  border: 1px solid #aaa;
  border-radius: 4px;
  cursor: text;
  outline: 0; }
  .select2-container--classic .select2-selection--multiple:focus {
    border: 1px solid #5897fb; }
  .select2-container--classic .select2-selection--multiple .select2-selection__rendered {
    list-style: none;
    margin: 0;
    padding: 0 5px; }
  .select2-container--classic .select2-selection--multiple .select2-selection__clear {
    display: none; }
  .select2-container--classic .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px; }
  .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove {
    color: #888;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px; }
    .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #555; }
.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
  float: right;
  margin-left: 5px;
  margin-right: auto; }
.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
  margin-left: 2px;
  margin-right: auto; }
.select2-container--classic.select2-container--open .select2-selection--multiple {
  border: 1px solid #5897fb; }
.select2-container--classic.select2-container--open.select2-container--above .select2-selection--multiple {
  border-top: none;
  border-top-left-radius: 0;
  border-top-right-radius: 0; }
.select2-container--classic.select2-container--open.select2-container--below .select2-selection--multiple {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0; }
.select2-container--classic .select2-search--dropdown .select2-search__field {
  border: 1px solid #aaa;
  outline: 0; }
.select2-container--classic .select2-search--inline .select2-search__field {
  outline: 0;
  box-shadow: none; }
.select2-container--classic .select2-dropdown {
  background-color: white;
  border: 1px solid transparent; }
.select2-container--classic .select2-dropdown--above {
  border-bottom: none; }
.select2-container--classic .select2-dropdown--below {
  border-top: none; }
.select2-container--classic .select2-results > .select2-results__options {
  max-height: 200px;
  overflow-y: auto; }
.select2-container--classic .select2-results__option[role=group] {
  padding: 0; }
.select2-container--classic .select2-results__option[aria-disabled=true] {
  color: grey; }
.select2-container--classic .select2-results__option--highlighted[aria-selected] {
  background-color: #3875d7;
  color: white; }
.select2-container--classic .select2-results__group {
  cursor: default;
  display: block;
  padding: 6px; }
.select2-container--classic.select2-container--open .select2-dropdown {
  border-color: #5897fb; }

/*!
 * Select2 Bootstrap Theme v0.1.0-beta.10 (https://select2.github.io/select2-bootstrap-theme)
 * Copyright 2015-2017 Florian Kissling and contributors (https://github.com/select2/select2-bootstrap-theme/graphs/contributors)
 * Licensed under MIT (https://github.com/select2/select2-bootstrap-theme/blob/master/LICENSE)
 */
.select2-container--bootstrap {
  display: block; }
  .select2-container--bootstrap .select2-selection {
    background-color: #ffffff;
    border: 1px solid #ebedf2;
    border-radius: 4px;
    color: inherit;
    font-size: 13px;
    outline: 0;
    line-height: 1.5 !important; }
    .select2-container--bootstrap .select2-selection.form-control {
      border-radius: 4px; }
  .select2-container--bootstrap .select2-search--dropdown .select2-search__field {
    background-color: #ffffff;
    border: 1px solid #ebedf2;
    border-radius: 4px;
    color: #555;
    font-size: 13px;
    padding: 4px 10px; }
  .select2-container--bootstrap .select2-search__field {
    outline: 0; }
    .select2-container--bootstrap .select2-search__field::-webkit-input-placeholder, .select2-container--bootstrap .select2-search__field:-moz-placeholder {
      color: #999; }
    .select2-container--bootstrap .select2-search__field::-moz-placeholder {
      color: #999;
      opacity: 1; }
    .select2-container--bootstrap .select2-search__field:-ms-input-placeholder {
      color: #999; }
  .select2-container--bootstrap .select2-results__option {
    padding: 6px 12px; }
    .select2-container--bootstrap .select2-results__option[role=group] {
      padding: 0; }
    .select2-container--bootstrap .select2-results__option[aria-disabled=true] {
      color: #777;
      cursor: not-allowed; }
    .select2-container--bootstrap .select2-results__option[aria-selected=true] {
      background-color: #f5f5f5;
      color: #262626; }
  .select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
    background-color: #1572E8;
    color: #ffffff; }
  .select2-container--bootstrap .select2-results__option .select2-results__option {
    padding: 6px 12px; }
    .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__group {
      padding-left: 0; }
    .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__option {
      margin-left: -12px;
      padding-left: 24px; }
      .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
        margin-left: -24px;
        padding-left: 36px; }
        .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
          margin-left: -36px;
          padding-left: 48px; }
          .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -48px;
            padding-left: 60px; }
            .select2-container--bootstrap .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
              margin-left: -60px;
              padding-left: 72px; }
  .select2-container--bootstrap .select2-results__group {
    color: #9E9E9E;
    font-weight: 400;
    display: block;
    padding: 7px 12px;
    line-height: 1.42857143;
    white-space: nowrap;
    margin-top: 6px; }
  .select2-container--bootstrap.select2-container--focus .select2-selection {
    border-color: #66afe9; }
  .select2-container--bootstrap.select2-container--open .select2-selection {
    -webkit-box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    -moz-box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    box-shadow: 0px 0px 15px 1px rgba(69, 65, 78, 0.2) !important;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s; }
    .select2-container--bootstrap.select2-container--open .select2-selection .select2-selection__arrow b {
      border-color: transparent transparent #999;
      border-width: 0 4px 4px; }
  .select2-container--bootstrap.select2-container--open.select2-container--below .select2-selection {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    border-bottom-color: transparent; }
  .select2-container--bootstrap.select2-container--open.select2-container--above .select2-selection {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    border-top-color: transparent; }
  .select2-container--bootstrap .select2-selection__clear {
    color: #999;
    cursor: pointer;
    float: right;
    font-weight: 700;
    margin-right: 10px; }
    .select2-container--bootstrap .select2-selection__clear:hover {
      color: #333; }
  .select2-container--bootstrap.select2-container--disabled .select2-selection {
    border-color: #ccc;
    -webkit-box-shadow: none;
    box-shadow: none; }
  .select2-container--bootstrap.select2-container--disabled .select2-search__field {
    cursor: not-allowed; }
  .select2-container--bootstrap.select2-container--disabled .select2-selection {
    cursor: not-allowed;
    background-color: #eee; }
  .select2-container--bootstrap.select2-container--disabled .select2-selection--multiple .select2-selection__choice {
    background-color: #eee; }
  .select2-container--bootstrap.select2-container--disabled .select2-selection--multiple .select2-selection__choice__remove {
    display: none; }
  .select2-container--bootstrap.select2-container--disabled .select2-selection__clear {
    display: none; }
  .select2-container--bootstrap .select2-dropdown {
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    border-color: #ebedf2;
    overflow-x: hidden;
    margin-top: -1px; }
  .select2-container--bootstrap .select2-dropdown--above {
    -webkit-box-shadow: 0 -6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 -6px 12px rgba(0, 0, 0, 0.175);
    margin-top: 1px; }
  .select2-container--bootstrap .select2-results > .select2-results__options {
    max-height: 200px;
    overflow-y: auto; }
  .select2-container--bootstrap .select2-selection--single {
    height: 40px;
    line-height: 1.42857143;
    padding: .6rem 1rem; }
    .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
      position: absolute;
      bottom: 0;
      right: 12px;
      top: 0;
      width: 4px; }
      .select2-container--bootstrap .select2-selection--single .select2-selection__arrow b {
        border-color: #999 transparent transparent;
        border-style: solid;
        border-width: 4px 4px 0;
        height: 0;
        left: 0;
        margin-left: -4px;
        margin-top: -2px;
        position: absolute;
        top: 50%;
        width: 0; }
    .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
      color: #555;
      padding: 0; }
    .select2-container--bootstrap .select2-selection--single .select2-selection__placeholder {
      color: #999; }
  .select2-container--bootstrap .select2-selection--multiple {
    padding: 3.25px 0px;
    height: auto; }
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__rendered {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      display: block;
      line-height: 1.42857143;
      list-style: none;
      margin: 0;
      overflow: hidden;
      padding: 0;
      width: 100%;
      text-overflow: ellipsis;
      white-space: nowrap; }
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__placeholder {
      color: #999;
      float: left;
      margin-top: 5px; }
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
      color: #555;
      background: #ffffff;
      border: 1px solid #ccc;
      border-radius: 30px;
      cursor: default;
      float: left;
      margin: 5px 0 0 6px;
      font-size: 11px;
      padding: 3px 23px 3px 10px;
      position: relative; }
    .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field {
      background: 0 0;
      padding: 0 12px;
      height: 32px;
      line-height: 1.42857143;
      margin-top: 0;
      min-width: 5em; }
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
      color: #666 !important;
      cursor: pointer;
      display: inline-block;
      margin-right: 3px;
      position: absolute;
      right: 5px;
      font-weight: 400; }
      .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #666 !important; }
    .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear {
      margin-top: 6px; }

.form-group-sm .select2-container--bootstrap .select2-selection--single, .input-group-sm .select2-container--bootstrap .select2-selection--single, .select2-container--bootstrap .select2-selection--single.input-sm {
  border-radius: 3px;
  font-size: 12px;
  height: 30px;
  line-height: 1.5;
  padding: 5px 22px 5px 10px; }

.form-group-sm .select2-container--bootstrap .select2-selection--single .select2-selection__arrow b, .input-group-sm .select2-container--bootstrap .select2-selection--single .select2-selection__arrow b, .select2-container--bootstrap .select2-selection--single.input-sm .select2-selection__arrow b {
  margin-left: -5px; }

.form-group-sm .select2-container--bootstrap .select2-selection--multiple, .input-group-sm .select2-container--bootstrap .select2-selection--multiple, .select2-container--bootstrap .select2-selection--multiple.input-sm {
  min-height: 30px;
  border-radius: 3px; }

.form-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice, .input-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice, .select2-container--bootstrap .select2-selection--multiple.input-sm .select2-selection__choice {
  font-size: 12px;
  line-height: 1.5;
  margin: 4px 0 0 5px;
  padding: 0 5px; }

.form-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field, .input-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field, .select2-container--bootstrap .select2-selection--multiple.input-sm .select2-search--inline .select2-search__field {
  padding: 0 10px;
  font-size: 12px;
  height: 28px;
  line-height: 1.5; }

.form-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear, .input-group-sm .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear, .select2-container--bootstrap .select2-selection--multiple.input-sm .select2-selection__clear {
  margin-top: 5px; }

.form-group-lg .select2-container--bootstrap .select2-selection--single, .input-group-lg .select2-container--bootstrap .select2-selection--single, .select2-container--bootstrap .select2-selection--single.input-lg {
  border-radius: 6px;
  font-size: 18px;
  height: 46px;
  line-height: 1.3333333;
  padding: 10px 31px 10px 16px; }

.form-group-lg .select2-container--bootstrap .select2-selection--single .select2-selection__arrow, .input-group-lg .select2-container--bootstrap .select2-selection--single .select2-selection__arrow, .select2-container--bootstrap .select2-selection--single.input-lg .select2-selection__arrow {
  width: 5px; }

.form-group-lg .select2-container--bootstrap .select2-selection--single .select2-selection__arrow b, .input-group-lg .select2-container--bootstrap .select2-selection--single .select2-selection__arrow b, .select2-container--bootstrap .select2-selection--single.input-lg .select2-selection__arrow b {
  border-width: 5px 5px 0;
  margin-left: -10px;
  margin-top: -2.5px; }

.form-group-lg .select2-container--bootstrap .select2-selection--multiple, .input-group-lg .select2-container--bootstrap .select2-selection--multiple, .select2-container--bootstrap .select2-selection--multiple.input-lg {
  min-height: 46px;
  border-radius: 6px; }

.form-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice, .input-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice, .select2-container--bootstrap .select2-selection--multiple.input-lg .select2-selection__choice {
  font-size: 18px;
  line-height: 1.3333333;
  border-radius: 4px;
  margin: 9px 0 0 8px;
  padding: 0 10px; }

.form-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field, .input-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field, .select2-container--bootstrap .select2-selection--multiple.input-lg .select2-search--inline .select2-search__field {
  padding: 0 16px;
  font-size: 18px;
  height: 44px;
  line-height: 1.3333333; }

.form-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear, .input-group-lg .select2-container--bootstrap .select2-selection--multiple .select2-selection__clear, .select2-container--bootstrap .select2-selection--multiple.input-lg .select2-selection__clear {
  margin-top: 10px; }

.input-group-lg .select2-container--bootstrap .select2-selection.select2-container--open .select2-selection--single .select2-selection__arrow b {
  border-color: transparent transparent #999;
  border-width: 0 5px 5px; }

.select2-container--bootstrap .select2-selection.input-lg.select2-container--open .select2-selection--single .select2-selection__arrow b {
  border-color: transparent transparent #999;
  border-width: 0 5px 5px; }
.select2-container--bootstrap[dir=rtl] .select2-selection--single {
  padding-left: 24px;
  padding-right: 12px; }
  .select2-container--bootstrap[dir=rtl] .select2-selection--single .select2-selection__rendered {
    padding-right: 0;
    padding-left: 0;
    text-align: right; }
  .select2-container--bootstrap[dir=rtl] .select2-selection--single .select2-selection__clear {
    float: left; }
  .select2-container--bootstrap[dir=rtl] .select2-selection--single .select2-selection__arrow {
    left: 12px;
    right: auto; }
    .select2-container--bootstrap[dir=rtl] .select2-selection--single .select2-selection__arrow b {
      margin-left: 0; }
.select2-container--bootstrap[dir=rtl] .select2-selection--multiple .select2-search--inline, .select2-container--bootstrap[dir=rtl] .select2-selection--multiple .select2-selection__choice, .select2-container--bootstrap[dir=rtl] .select2-selection--multiple .select2-selection__placeholder {
  float: right; }
.select2-container--bootstrap[dir=rtl] .select2-selection--multiple .select2-selection__choice {
  margin-left: 0;
  margin-right: 6px; }
.select2-container--bootstrap[dir=rtl] .select2-selection--multiple .select2-selection__choice__remove {
  margin-left: 2px;
  margin-right: auto; }

.has-warning .select2-dropdown, .has-warning .select2-selection {
  border-color: #8a6d3b; }
.has-warning .select2-container--focus .select2-selection, .has-warning .select2-container--open .select2-selection {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #c0a16b;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #c0a16b;
  border-color: #66512c; }
.has-warning.select2-drop-active {
  border-color: #66512c; }
  .has-warning.select2-drop-active.select2-drop.select2-drop-above {
    border-top-color: #66512c; }

.has-error .select2-dropdown, .has-error .select2-selection {
  border-color: #F25961; }
  .has-error .select2-dropdown .select2-selection__rendered, .has-error .select2-selection .select2-selection__rendered {
    color: #F25961; }
.has-error .select2-container--focus .select2-selection, .has-error .select2-container--open .select2-selection {
  border-color: #F25961; }
.has-error.select2-drop-active {
  border-color: #F25961; }
  .has-error.select2-drop-active.select2-drop.select2-drop-above {
    border-top-color: #F25961; }

.has-success .select2-dropdown, .has-success .select2-selection {
  border-color: #31CE36; }
  .has-success .select2-dropdown .select2-selection__rendered, .has-success .select2-selection .select2-selection__rendered {
    color: #31CE36; }
.has-success .select2-container--focus .select2-selection, .has-success .select2-container--open .select2-selection {
  border-color: #31CE36; }
.has-success.select2-drop-active {
  border-color: #31CE36; }
  .has-success.select2-drop-active.select2-drop.select2-drop-above {
    border-top-color: #31CE36; }

.input-group > .select2-hidden-accessible:first-child + .select2-container--bootstrap > .selection > .select2-selection {
  border-bottom-right-radius: 0;
  border-top-right-radius: 0; }
  .input-group > .select2-hidden-accessible:first-child + .select2-container--bootstrap > .selection > .select2-selection.form-control {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0; }
.input-group > .select2-hidden-accessible:not(:first-child) + .select2-container--bootstrap:not(:last-child) > .selection > .select2-selection {
  border-radius: 0; }
  .input-group > .select2-hidden-accessible:not(:first-child) + .select2-container--bootstrap:not(:last-child) > .selection > .select2-selection.form-control {
    border-radius: 0; }
.input-group > .select2-hidden-accessible:not(:first-child):not(:last-child) + .select2-container--bootstrap:last-child > .selection > .select2-selection {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0; }
  .input-group > .select2-hidden-accessible:not(:first-child):not(:last-child) + .select2-container--bootstrap:last-child > .selection > .select2-selection.form-control {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0; }
.input-group > .select2-container--bootstrap {
  display: table;
  table-layout: fixed;
  position: relative;
  z-index: 2;
  width: 100%;
  margin-bottom: 0;
  vertical-align: top; }
  .input-group > .select2-container--bootstrap > .selection > .select2-selection.form-control {
    float: none; }
  .input-group > .select2-container--bootstrap.select2-container--focus, .input-group > .select2-container--bootstrap.select2-container--open {
    z-index: 3; }
  .input-group > .select2-container--bootstrap .input-group-btn {
    vertical-align: top; }
    .input-group > .select2-container--bootstrap .input-group-btn .btn {
      vertical-align: top; }

.form-control.select2-hidden-accessible {
  position: absolute !important;
  width: 1px !important; }

.select2-black .select2-selection__choice .select2-selection__choice__remove, .select2-primary .select2-selection__choice .select2-selection__choice__remove, .select2-info .select2-selection__choice .select2-selection__choice__remove, .select2-danger .select2-selection__choice .select2-selection__choice__remove, .select2-warning .select2-selection__choice .select2-selection__choice__remove, .select2-success .select2-selection__choice .select2-selection__choice__remove {
  color: #ffffff !important; }
  .select2-black .select2-selection__choice .select2-selection__choice__remove:hover, .select2-primary .select2-selection__choice .select2-selection__choice__remove:hover, .select2-info .select2-selection__choice .select2-selection__choice__remove:hover, .select2-danger .select2-selection__choice .select2-selection__choice__remove:hover, .select2-warning .select2-selection__choice .select2-selection__choice__remove:hover, .select2-success .select2-selection__choice .select2-selection__choice__remove:hover {
    color: #ffffff !important; }

.select2-black .select2-selection__choice {
  background: #1a2035 !important;
  border-color: #1a2035 !important;
  color: #ffffff !important; }

.select2-primary .select2-selection__choice {
  background: #1572E8 !important;
  border-color: #1572E8 !important;
  color: #ffffff !important; }

.select2-secondary .select2-selection__choice {
  background: #6861CE !important;
  border-color: #6861CE !important;
  color: #ffffff !important; }

.select2-info .select2-selection__choice {
  background: #48ABF7 !important;
  border-color: #48ABF7 !important;
  color: #ffffff !important; }

.select2-success .select2-selection__choice {
  background: #31CE36 !important;
  border-color: #31CE36 !important;
  color: #ffffff !important; }

.select2-danger .select2-selection__choice {
  background: #F25961 !important;
  border-color: #F25961 !important;
  color: #ffffff !important; }

.select2-warning .select2-selection__choice {
  background: #FFAD46 !important;
  border-color: #FFAD46 !important;
  color: #ffffff !important; }

@media (min-width: 768px) {
  .form-inline .select2-container--bootstrap {
    display: inline-block; } }
/*      Bootstrap Tagsinput     */
.bootstrap-tagsinput {
  background-color: #ffffff;
  display: inline-block;
  padding: 4px 6px;
  color: #555;
  vertical-align: middle;
  border-radius: 4px;
  max-width: 100%;
  line-height: 22px;
  cursor: text; }
  .bootstrap-tagsinput input {
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
    padding: 0 6px;
    margin: 0;
    width: auto;
    max-width: inherit; }
  .bootstrap-tagsinput.form-control input::-moz-placeholder {
    color: #777;
    opacity: 1; }
  .bootstrap-tagsinput.form-control input:-ms-input-placeholder, .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
    color: #777; }
  .bootstrap-tagsinput input:focus {
    border: none;
    box-shadow: none; }
  .bootstrap-tagsinput .tag {
    margin-right: 2px;
    margin-bottom: 10px; }
    .bootstrap-tagsinput .tag [data-role="remove"] {
      margin-left: 8px;
      cursor: pointer; }
      .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "x";
        padding: 0px 2px; }
      .bootstrap-tagsinput .tag [data-role="remove"]:hover {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); }
        .bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
          box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); }

/*
 * The MIT License
 * Copyright (c) 2012 Matias Meno <m@tias.me>
 */
@-webkit-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-moz-keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@keyframes passing-through {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30%, 70% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); }
  100% {
    opacity: 0;
    -webkit-transform: translateY(-40px);
    -moz-transform: translateY(-40px);
    -ms-transform: translateY(-40px);
    -o-transform: translateY(-40px);
    transform: translateY(-40px); } }
@-webkit-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-moz-keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@keyframes slide-in {
  0% {
    opacity: 0;
    -webkit-transform: translateY(40px);
    -moz-transform: translateY(40px);
    -ms-transform: translateY(40px);
    -o-transform: translateY(40px);
    transform: translateY(40px); }
  30% {
    opacity: 1;
    -webkit-transform: translateY(0px);
    -moz-transform: translateY(0px);
    -ms-transform: translateY(0px);
    -o-transform: translateY(0px);
    transform: translateY(0px); } }
@-webkit-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@-moz-keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
@keyframes pulse {
  0% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); }
  10% {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1); }
  20% {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1); } }
.dropzone, .dropzone * {
  box-sizing: border-box; }

.dropzone {
  min-height: 150px;
  border: 2px solid rgba(0, 0, 0, 0.3);
  background: white;
  padding: 20px 20px; }
  .dropzone.dz-clickable {
    cursor: pointer; }
    .dropzone.dz-clickable * {
      cursor: default; }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
      cursor: pointer; }
  .dropzone.dz-started .dz-message {
    display: none; }
  .dropzone.dz-drag-hover {
    border-style: solid; }
    .dropzone.dz-drag-hover .dz-message {
      opacity: 0.5; }
  .dropzone .dz-message {
    text-align: center;
    margin: 2em 0; }
  .dropzone .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px;
    min-height: 100px; }
    .dropzone .dz-preview:hover {
      z-index: 1000; }
      .dropzone .dz-preview:hover .dz-details {
        opacity: 1; }
    .dropzone .dz-preview.dz-file-preview .dz-image {
      border-radius: 20px;
      background: #999;
      background: linear-gradient(to bottom, #eee, #ddd); }
    .dropzone .dz-preview.dz-file-preview .dz-details {
      opacity: 1; }
    .dropzone .dz-preview.dz-image-preview {
      background: white; }
      .dropzone .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear; }
    .dropzone .dz-preview .dz-remove {
      font-size: 14px;
      text-align: center;
      display: block;
      cursor: pointer;
      border: none; }
      .dropzone .dz-preview .dz-remove:hover {
        text-decoration: underline; }
    .dropzone .dz-preview:hover .dz-details {
      opacity: 1; }
    .dropzone .dz-preview .dz-details {
      z-index: 20;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      font-size: 13px;
      min-width: 100%;
      max-width: 100%;
      padding: 2em 1em;
      text-align: center;
      color: rgba(0, 0, 0, 0.9);
      line-height: 150%; }
      .dropzone .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px; }
      .dropzone .dz-preview .dz-details .dz-filename {
        white-space: nowrap; }
        .dropzone .dz-preview .dz-details .dz-filename:hover span {
          border: 1px solid rgba(200, 200, 200, 0.8);
          background-color: rgba(255, 255, 255, 0.8); }
        .dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
          overflow: hidden;
          text-overflow: ellipsis; }
          .dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
            border: 1px solid transparent; }
      .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px; }
    .dropzone .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(8px); }
    .dropzone .dz-preview .dz-image {
      border-radius: 20px;
      overflow: hidden;
      width: 120px;
      height: 120px;
      position: relative;
      display: block;
      z-index: 10; }
      .dropzone .dz-preview .dz-image img {
        display: block; }
    .dropzone .dz-preview.dz-success .dz-success-mark {
      -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview.dz-error .dz-error-mark {
      opacity: 1;
      -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1); }
    .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
      pointer-events: none;
      opacity: 0;
      z-index: 500;
      position: absolute;
      display: block;
      top: 50%;
      left: 50%;
      margin-left: -27px;
      margin-top: -27px; }
      .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px; }
    .dropzone .dz-preview.dz-processing .dz-progress {
      opacity: 1;
      -webkit-transition: all 0.2s linear;
      -moz-transition: all 0.2s linear;
      -ms-transition: all 0.2s linear;
      -o-transition: all 0.2s linear;
      transition: all 0.2s linear; }
    .dropzone .dz-preview.dz-complete .dz-progress {
      opacity: 0;
      -webkit-transition: opacity 0.4s ease-in;
      -moz-transition: opacity 0.4s ease-in;
      -ms-transition: opacity 0.4s ease-in;
      -o-transition: opacity 0.4s ease-in;
      transition: opacity 0.4s ease-in; }
    .dropzone .dz-preview:not(.dz-processing) .dz-progress {
      -webkit-animation: pulse 6s ease infinite;
      -moz-animation: pulse 6s ease infinite;
      -ms-animation: pulse 6s ease infinite;
      -o-animation: pulse 6s ease infinite;
      animation: pulse 6s ease infinite; }
    .dropzone .dz-preview .dz-progress {
      opacity: 1;
      z-index: 1000;
      pointer-events: none;
      position: absolute;
      height: 16px;
      left: 50%;
      top: 50%;
      margin-top: -8px;
      width: 80px;
      margin-left: -40px;
      background: rgba(255, 255, 255, 0.9);
      -webkit-transform: scale(1);
      border-radius: 8px;
      overflow: hidden; }
      .dropzone .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out; }
    .dropzone .dz-preview.dz-error .dz-error-message {
      display: block; }
    .dropzone .dz-preview.dz-error:hover .dz-error-message {
      opacity: 1;
      pointer-events: auto; }
    .dropzone .dz-preview .dz-error-message {
      pointer-events: none;
      z-index: 1000;
      position: absolute;
      display: block;
      display: none;
      opacity: 0;
      -webkit-transition: opacity 0.3s ease;
      -moz-transition: opacity 0.3s ease;
      -ms-transition: opacity 0.3s ease;
      -o-transition: opacity 0.3s ease;
      transition: opacity 0.3s ease;
      border-radius: 8px;
      font-size: 13px;
      top: 130px;
      left: -10px;
      width: 140px;
      background: #be2626;
      background: linear-gradient(to bottom, #be2626, #a92222);
      padding: 0.5em 1.2em;
      color: white; }
      .dropzone .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626; }

/*      Summernote     */
@font-face {
  font-family: "summernote";
  font-style: normal;
  font-weight: normal;
  src: url("../fonts/summernote/summernote4c4d.eot?e557617934c52ea068954af79ed7c221");
  src: url("../fonts/summernote/summernoted41d.eot?#iefix") format("embedded-opentype"), url("../fonts/summernote/summernote4c4d.woff?e557617934c52ea068954af79ed7c221") format("woff"), url("../fonts/summernote/summernote4c4d.ttf?e557617934c52ea068954af79ed7c221") format("truetype"); }
[class^="note-icon-"]:before, [class*=" note-icon-"]:before {
  display: inline-block;
  font: normal normal normal 14px summernote;
  font-size: inherit;
  -webkit-font-smoothing: antialiased;
  text-decoration: inherit;
  text-rendering: auto;
  text-transform: none;
  vertical-align: middle;
  speak: none;
  -moz-osx-font-smoothing: grayscale; }

.note-icon-align-center:before, .note-icon-align-indent:before, .note-icon-align-justify:before, .note-icon-align-left:before, .note-icon-align-outdent:before, .note-icon-align-right:before, .note-icon-align:before, .note-icon-arrow-circle-down:before, .note-icon-arrow-circle-left:before, .note-icon-arrow-circle-right:before, .note-icon-arrow-circle-up:before, .note-icon-arrows-alt:before, .note-icon-arrows-h:before, .note-icon-arrows-v:before, .note-icon-bold:before, .note-icon-caret:before, .note-icon-chain-broken:before, .note-icon-circle:before, .note-icon-close:before, .note-icon-code:before, .note-icon-col-after:before, .note-icon-col-before:before, .note-icon-col-remove:before, .note-icon-eraser:before, .note-icon-font:before, .note-icon-frame:before, .note-icon-italic:before, .note-icon-link:before, .note-icon-magic:before, .note-icon-menu-check:before, .note-icon-minus:before, .note-icon-orderedlist:before, .note-icon-pencil:before, .note-icon-picture:before, .note-icon-question:before, .note-icon-redo:before, .note-icon-row-above:before, .note-icon-row-below:before, .note-icon-row-remove:before, .note-icon-special-character:before, .note-icon-square:before, .note-icon-strikethrough:before, .note-icon-subscript:before, .note-icon-summernote:before, .note-icon-superscript:before, .note-icon-table:before, .note-icon-text-height:before, .note-icon-trash:before, .note-icon-underline:before, .note-icon-undo:before, .note-icon-unorderedlist:before, .note-icon-video:before {
  display: inline-block;
  font-family: "summernote";
  font-style: normal;
  font-weight: normal;
  text-decoration: inherit; }

.note-icon-align-center:before {
  content: "\f101"; }

.note-icon-align-indent:before {
  content: "\f102"; }

.note-icon-align-justify:before {
  content: "\f103"; }

.note-icon-align-left:before {
  content: "\f104"; }

.note-icon-align-outdent:before {
  content: "\f105"; }

.note-icon-align-right:before {
  content: "\f106"; }

.note-icon-align:before {
  content: "\f107"; }

.note-icon-arrow-circle-down:before {
  content: "\f108"; }

.note-icon-arrow-circle-left:before {
  content: "\f109"; }

.note-icon-arrow-circle-right:before {
  content: "\f10a"; }

.note-icon-arrow-circle-up:before {
  content: "\f10b"; }

.note-icon-arrows-alt:before {
  content: "\f10c"; }

.note-icon-arrows-h:before {
  content: "\f10d"; }

.note-icon-arrows-v:before {
  content: "\f10e"; }

.note-icon-bold:before {
  content: "\f10f"; }

.note-icon-caret:before {
  content: "\f110"; }

.note-icon-chain-broken:before {
  content: "\f111"; }

.note-icon-circle:before {
  content: "\f112"; }

.note-icon-close:before {
  content: "\f113"; }

.note-icon-code:before {
  content: "\f114"; }

.note-icon-col-after:before {
  content: "\f115"; }

.note-icon-col-before:before {
  content: "\f116"; }

.note-icon-col-remove:before {
  content: "\f117"; }

.note-icon-eraser:before {
  content: "\f118"; }

.note-icon-font:before {
  content: "\f119"; }

.note-icon-frame:before {
  content: "\f11a"; }

.note-icon-italic:before {
  content: "\f11b"; }

.note-icon-link:before {
  content: "\f11c"; }

.note-icon-magic:before {
  content: "\f11d"; }

.note-icon-menu-check:before {
  content: "\f11e"; }

.note-icon-minus:before {
  content: "\f11f"; }

.note-icon-orderedlist:before {
  content: "\f120"; }

.note-icon-pencil:before {
  content: "\f121"; }

.note-icon-picture:before {
  content: "\f122"; }

.note-icon-question:before {
  content: "\f123"; }

.note-icon-redo:before {
  content: "\f124"; }

.note-icon-row-above:before {
  content: "\f125"; }

.note-icon-row-below:before {
  content: "\f126"; }

.note-icon-row-remove:before {
  content: "\f127"; }

.note-icon-special-character:before {
  content: "\f128"; }

.note-icon-square:before {
  content: "\f129"; }

.note-icon-strikethrough:before {
  content: "\f12a"; }

.note-icon-subscript:before {
  content: "\f12b"; }

.note-icon-summernote:before {
  content: "\f12c"; }

.note-icon-superscript:before {
  content: "\f12d"; }

.note-icon-table:before {
  content: "\f12e"; }

.note-icon-text-height:before {
  content: "\f12f"; }

.note-icon-trash:before {
  content: "\f130"; }

.note-icon-underline:before {
  content: "\f131"; }

.note-icon-undo:before {
  content: "\f132"; }

.note-icon-unorderedlist:before {
  content: "\f133"; }

.note-icon-video:before {
  content: "\f134"; }

.note-editor {
  position: relative; }
  .note-editor .note-dropzone {
    position: absolute;
    z-index: 100;
    display: none;
    color: #87cefa;
    background-color: white;
    opacity: .95; }
    .note-editor .note-dropzone .note-dropzone-message {
      display: table-cell;
      font-size: 28px;
      font-weight: bold;
      text-align: center;
      vertical-align: middle; }
    .note-editor .note-dropzone.hover {
      color: #098ddf; }
  .note-editor.dragover .note-dropzone {
    display: table; }
  .note-editor .note-editing-area {
    position: relative; }
    .note-editor .note-editing-area .note-editable {
      outline: 0; }
      .note-editor .note-editing-area .note-editable sup {
        vertical-align: super; }
      .note-editor .note-editing-area .note-editable sub {
        vertical-align: sub; }
    .note-editor .note-editing-area img.note-float-left {
      margin-right: 10px; }
    .note-editor .note-editing-area img.note-float-right {
      margin-left: 10px; }
  .note-editor.note-frame {
    border: 1px solid #a9a9a9; }
    .note-editor.note-frame.codeview .note-editing-area .note-editable {
      display: none; }
    .note-editor.note-frame.codeview .note-editing-area .note-codable {
      display: block; }
    .note-editor.note-frame .note-editing-area {
      overflow: hidden; }
      .note-editor.note-frame .note-editing-area .note-editable {
        padding: 10px;
        overflow: auto;
        color: #000;
        background-color: #ffffff; }
        .note-editor.note-frame .note-editing-area .note-editable[contenteditable="false"] {
          background-color: #e5e5e5; }
      .note-editor.note-frame .note-editing-area .note-codable {
        display: none;
        width: 100%;
        padding: 10px;
        margin-bottom: 0;
        font-family: Menlo,Monaco,monospace,sans-serif;
        font-size: 14px;
        color: #ccc;
        background-color: #222;
        border: 0;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        box-shadow: none;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        resize: none; }
    .note-editor.note-frame.fullscreen {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1050;
      width: 100% !important; }
      .note-editor.note-frame.fullscreen .note-editable {
        background-color: white; }
      .note-editor.note-frame.fullscreen .note-resizebar {
        display: none; }
    .note-editor.note-frame .note-statusbar {
      background-color: #f5f5f5;
      border-bottom-right-radius: 4px;
      border-bottom-left-radius: 4px; }
      .note-editor.note-frame .note-statusbar .note-resizebar {
        width: 100%;
        height: 8px;
        padding-top: 1px;
        cursor: ns-resize; }
        .note-editor.note-frame .note-statusbar .note-resizebar .note-icon-bar {
          width: 20px;
          margin: 1px auto;
          border-top: 1px solid #a9a9a9; }
    .note-editor.note-frame .note-placeholder {
      padding: 10px; }

.note-popover.popover {
  display: none;
  max-width: none; }
  .note-popover.popover .popover-content a {
    display: inline-block;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: middle; }
  .note-popover.popover .arrow {
    left: 20px !important; }
.note-popover .popover-content {
  padding: 0 0 5px 5px;
  margin: 0; }

.card-header.note-toolbar {
  padding: 0 0 5px 5px;
  margin: 0; }

.note-popover .popover-content > .btn-group, .card-header.note-toolbar > .btn-group {
  margin-top: 5px;
  margin-right: 5px;
  margin-left: 0; }

.note-popover .popover-content .btn-group .note-table, .card-header.note-toolbar .btn-group .note-table {
  min-width: 0;
  padding: 5px; }

.note-popover .popover-content .btn-group .note-table .note-dimension-picker, .card-header.note-toolbar .btn-group .note-table .note-dimension-picker {
  font-size: 18px; }

.note-popover .popover-content .btn-group .note-table .note-dimension-picker .note-dimension-picker-mousecatcher, .card-header.note-toolbar .btn-group .note-table .note-dimension-picker .note-dimension-picker-mousecatcher {
  position: absolute !important;
  z-index: 3;
  width: 10em;
  height: 10em;
  cursor: pointer; }

.note-popover .popover-content .btn-group .note-table .note-dimension-picker .note-dimension-picker-unhighlighted, .card-header.note-toolbar .btn-group .note-table .note-dimension-picker .note-dimension-picker-unhighlighted {
  position: relative !important;
  z-index: 1;
  width: 5em;
  height: 5em;
  background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAACVBMVEUAAIj4+Pjp6ekKlAqjAAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfYAR0BKhmnaJzPAAAAG0lEQVQI12NgAAOtVatWMTCohoaGUY+EmIkEAEruEzK2J7tvAAAAAElFTkSuQmCC") repeat; }

.note-popover .popover-content .btn-group .note-table .note-dimension-picker .note-dimension-picker-highlighted, .card-header.note-toolbar .btn-group .note-table .note-dimension-picker .note-dimension-picker-highlighted {
  position: absolute !important;
  z-index: 2;
  width: 1em;
  height: 1em;
  background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAACVBMVEUAAIjd6vvD2f9LKLW+AAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfYAR0BKwNDEVT0AAAAG0lEQVQI12NgAAOtVatWMTCohoaGUY+EmIkEAEruEzK2J7tvAAAAAElFTkSuQmCC") repeat; }

.note-popover .popover-content .note-style h1, .card-header.note-toolbar .note-style h1, .note-popover .popover-content .note-style h2, .card-header.note-toolbar .note-style h2, .note-popover .popover-content .note-style h3, .card-header.note-toolbar .note-style h3, .note-popover .popover-content .note-style h4, .card-header.note-toolbar .note-style h4, .note-popover .popover-content .note-style h5, .card-header.note-toolbar .note-style h5, .note-popover .popover-content .note-style h6, .card-header.note-toolbar .note-style h6, .note-popover .popover-content .note-style blockquote, .card-header.note-toolbar .note-style blockquote {
  margin: 0; }

.note-popover .popover-content .note-color .dropdown-toggle, .card-header.note-toolbar .note-color .dropdown-toggle {
  width: 20px;
  padding-left: 5px; }

.note-popover .popover-content .note-color .dropdown-menu, .card-header.note-toolbar .note-color .dropdown-menu {
  min-width: 337px; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette, .card-header.note-toolbar .note-color .dropdown-menu .note-palette {
  display: inline-block;
  width: 160px;
  margin: 0; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette:first-child, .card-header.note-toolbar .note-color .dropdown-menu .note-palette:first-child {
  margin: 0 5px; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette .note-palette-title, .card-header.note-toolbar .note-color .dropdown-menu .note-palette .note-palette-title {
  margin: 2px 7px;
  font-size: 12px;
  text-align: center;
  border-bottom: 1px solid #eee; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette .note-color-reset, .card-header.note-toolbar .note-color .dropdown-menu .note-palette .note-color-reset {
  width: 100%;
  padding: 0 3px;
  margin: 3px;
  font-size: 11px;
  cursor: pointer;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette .note-color-row, .card-header.note-toolbar .note-color .dropdown-menu .note-palette .note-color-row {
  height: 20px; }

.note-popover .popover-content .note-color .dropdown-menu .note-palette .note-color-reset:hover, .card-header.note-toolbar .note-color .dropdown-menu .note-palette .note-color-reset:hover {
  background: #eee; }

.note-popover .popover-content .note-para .dropdown-menu, .card-header.note-toolbar .note-para .dropdown-menu {
  min-width: 216px;
  padding: 5px; }

.note-popover .popover-content .note-para .dropdown-menu > div:first-child, .card-header.note-toolbar .note-para .dropdown-menu > div:first-child {
  margin-right: 5px; }

.note-popover .popover-content .dropdown-menu, .card-header.note-toolbar .dropdown-menu {
  min-width: 90px; }

.note-popover .popover-content .dropdown-menu.right, .card-header.note-toolbar .dropdown-menu.right {
  right: 0;
  left: auto; }

.note-popover .popover-content .dropdown-menu.right::before, .card-header.note-toolbar .dropdown-menu.right::before {
  right: 9px;
  left: auto !important; }

.note-popover .popover-content .dropdown-menu.right::after, .card-header.note-toolbar .dropdown-menu.right::after {
  right: 10px;
  left: auto !important; }

.note-popover .popover-content .dropdown-menu.note-check a i, .card-header.note-toolbar .dropdown-menu.note-check a i {
  color: deepskyblue;
  visibility: hidden; }

.note-popover .popover-content .dropdown-menu.note-check a.checked i, .card-header.note-toolbar .dropdown-menu.note-check a.checked i {
  visibility: visible; }

.note-popover .popover-content .note-fontsize-10, .card-header.note-toolbar .note-fontsize-10 {
  font-size: 10px; }

.note-popover .popover-content .note-color-palette, .card-header.note-toolbar .note-color-palette {
  line-height: 1; }

.note-popover .popover-content .note-color-palette div .note-color-btn, .card-header.note-toolbar .note-color-palette div .note-color-btn {
  width: 20px;
  height: 20px;
  padding: 0;
  margin: 0;
  border: 1px solid #ffffff; }

.note-popover .popover-content .note-color-palette div .note-color-btn:hover, .card-header.note-toolbar .note-color-palette div .note-color-btn:hover {
  border: 1px solid #000; }

.note-dialog > div {
  display: none; }
.note-dialog .form-group {
  margin-right: 0;
  margin-left: 0; }
.note-dialog .note-modal-form {
  margin: 0; }
.note-dialog .note-image-dialog .note-dropzone {
  min-height: 100px;
  margin-bottom: 10px;
  font-size: 30px;
  line-height: 4;
  color: lightgray;
  text-align: center;
  border: 4px dashed lightgray; }

@-moz-document url-prefix() {
  .note-image-input {
    height: auto; } }
.note-placeholder {
  position: absolute;
  display: none;
  color: gray; }

.note-handle .note-control-selection {
  position: absolute;
  display: none;
  border: 1px solid black; }
  .note-handle .note-control-selection > div {
    position: absolute; }
  .note-handle .note-control-selection .note-control-selection-bg {
    width: 100%;
    height: 100%;
    background-color: black;
    -webkit-opacity: .3;
    -khtml-opacity: .3;
    -moz-opacity: .3;
    opacity: .3;
    -ms-filter: alpha(opacity=30);
    filter: alpha(opacity=30); }
  .note-handle .note-control-selection .note-control-handle, .note-handle .note-control-selection .note-control-holder {
    width: 7px;
    height: 7px;
    border: 1px solid black; }
  .note-handle .note-control-selection .note-control-sizing {
    width: 7px;
    height: 7px;
    background-color: white;
    border: 1px solid black; }
  .note-handle .note-control-selection .note-control-nw {
    top: -5px;
    left: -5px;
    border-right: 0;
    border-bottom: 0; }
  .note-handle .note-control-selection .note-control-ne {
    top: -5px;
    right: -5px;
    border-bottom: 0;
    border-left: none; }
  .note-handle .note-control-selection .note-control-sw {
    bottom: -5px;
    left: -5px;
    border-top: 0;
    border-right: 0; }
  .note-handle .note-control-selection .note-control-se {
    right: -5px;
    bottom: -5px;
    cursor: se-resize; }
    .note-handle .note-control-selection .note-control-se.note-control-holder {
      cursor: default;
      border-top: 0;
      border-left: none; }
  .note-handle .note-control-selection .note-control-selection-info {
    right: 0;
    bottom: 0;
    padding: 5px;
    margin: 5px;
    font-size: 12px;
    color: white;
    background-color: black;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-opacity: .7;
    -khtml-opacity: .7;
    -moz-opacity: .7;
    opacity: .7;
    -ms-filter: alpha(opacity=70);
    filter: alpha(opacity=70); }

.note-hint-popover {
  min-width: 100px;
  padding: 2px; }
  .note-hint-popover .popover-content {
    max-height: 150px;
    padding: 3px;
    overflow: auto; }
    .note-hint-popover .popover-content .note-hint-group .note-hint-item {
      display: block !important;
      padding: 3px; }
      .note-hint-popover .popover-content .note-hint-group .note-hint-item.active, .note-hint-popover .popover-content .note-hint-group .note-hint-item:hover {
        display: block;
        clear: both;
        font-weight: 400;
        line-height: 1.4;
        color: white;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        background-color: #428bca;
        outline: 0; }

.board {
  display: block;
  padding: 1.5rem;
  white-space: nowrap;
  overflow-x: auto;
  height: calc(100vh - 127px);
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }

.kanban-board:after, .kanban-container:after {
  clear: both;
  content: ""; }

.kanban-container {
  position: relative;
  width: auto; }
  .kanban-container:after {
    display: block; }

.sortable-ghost {
  opacity: 0.4; }

.kanban-board {
  position: relative;
  background-color: #f3f3f3;
  box-shadow: 0 0 0 1px rgba(122, 128, 134, 0.05), 0 1px 3px 0 rgba(103, 110, 117, 0.15);
  border-radius: .25rem;
  padding: .5rem;
  display: inline-block;
  width: 18rem;
  padding: .5rem;
  vertical-align: top; }
  .kanban-board:not(:last-child) {
    margin-right: 1.25rem; }
  .kanban-board.disabled-board {
    opacity: .3; }
  .kanban-board.is-moving.gu-mirror {
    opacity: .8; }
    .kanban-board.is-moving.gu-mirror .kanban-drag {
      overflow: hidden;
      padding-right: 50px; }
  .kanban-board header {
    font-size: 16px;
    margin-bottom: .25rem;
    padding: 0 .25rem; }
    .kanban-board header .kanban-title-board {
      font-weight: 600;
      margin: 0;
      padding: 0;
      display: inline;
      white-space: normal;
      font-size: 15px; }
    .kanban-board header .kanban-title-button {
      float: right; }
  .kanban-board .kanban-drag {
    padding: 6px 0; }
  .kanban-board:after {
    display: block; }
  .kanban-board .form-group {
    padding: 0px;
    margin-top: 10px;
    margin-bottom: 10px; }

.kanban-item {
  background: #fff;
  padding: 15px;
  background: #fff;
  padding: 15px;
  margin-bottom: 6px;
  margin-top: 6px;
  box-shadow: 0 0 0 1px rgba(122, 128, 134, 0.05), 0 1px 3px 0 rgba(103, 110, 117, 0.15);
  border-radius: 5px;
  position: relative; }
  .kanban-item:hover {
    cursor: pointer;
    background: #f6f6f6; }
    .kanban-item:hover .kanban-edit {
      opacity: 1 !important; }
  .kanban-item:last-child {
    margin: 0; }
  .kanban-item.is-moving.gu-mirror {
    opacity: 0.8;
    height: auto !important; }
  .kanban-item .kanban-image {
    margin-left: -15px;
    margin-right: -15px;
    margin-top: -15px;
    margin-bottom: 15px; }
    .kanban-item .kanban-image img {
      border-top-left-radius: 5px;
      border-top-right-radius: 5px; }
  .kanban-item .kanban-title {
    font-weight: 600;
    font-size: 15px;
    color: inherit;
    text-decoration: none; }
  .kanban-item .kanban-badges {
    max-width: 100%;
    color: #6c757d;
    margin-top: 10px;
    font-size: 13px;
    margin-left: -5px; }
    .kanban-item .kanban-badges .kanban-badge {
      display: inline-block;
      padding: 2px 5px;
      border-radius: 3px; }
      .kanban-item .kanban-badges .kanban-badge:not(:first-child) {
        margin-left: 7px; }
      .kanban-item .kanban-badges .kanban-badge.bg-success, .kanban-item .kanban-badges .kanban-badge.bg-warning, .kanban-item .kanban-badges .kanban-badge.bg-danger {
        color: #fff; }
      .kanban-item .kanban-badges .kanban-badge:first-child.bg-success, .kanban-item .kanban-badges .kanban-badge:first-child.bg-warning, .kanban-item .kanban-badges .kanban-badge:first-child.bg-danger {
        margin-left: 5px; }
    .kanban-item .kanban-badges .badge-text {
      margin-left: 5px; }
  .kanban-item .kanban-edit {
    background: #f6f6f6;
    width: 25px;
    height: 25px;
    font-size: 13px;
    border-radius: 5px;
    position: absolute;
    top: 15px;
    right: 15px;
    justify-content: center;
    align-items: center;
    display: flex;
    opacity: 0; }

.kanban-title-button button {
  background: transparent;
  border: 0;
  color: #575962;
  padding: 0;
  font-size: 16px;
  cursor: pointer; }
.kanban-title-button .dropdown-kanban .dropdown-toggle:after {
  display: none; }

.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important; }

.gu-hide {
  display: none !important; }

.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important; }

.gu-transit {
  opacity: 0.2 !important; }

/**
* Owl Carousel v2.3.4
* Copyright 2013-2018 David Deutsch
* Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
*/
.owl-carousel {
  -webkit-tap-highlight-color: transparent;
  position: relative;
  display: none;
  width: 100%;
  z-index: 1; }
  .owl-carousel .owl-item {
    -webkit-tap-highlight-color: transparent;
    position: relative; }
  .owl-carousel .owl-stage {
    position: relative;
    -ms-touch-action: pan-Y;
    touch-action: manipulation;
    -moz-backface-visibility: hidden; }
    .owl-carousel .owl-stage:after {
      content: ".";
      display: block;
      clear: both;
      visibility: hidden;
      line-height: 0;
      height: 0; }
  .owl-carousel .owl-stage-outer {
    position: relative;
    overflow: hidden;
    -webkit-transform: translate3d(0, 0, 0); }
  .owl-carousel .owl-item, .owl-carousel .owl-wrapper {
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -ms-backface-visibility: hidden;
    -webkit-transform: translate3d(0, 0, 0);
    -moz-transform: translate3d(0, 0, 0);
    -ms-transform: translate3d(0, 0, 0); }
  .owl-carousel .owl-item {
    min-height: 1px;
    float: left;
    -webkit-backface-visibility: hidden;
    -webkit-touch-callout: none; }
    .owl-carousel .owl-item img {
      display: block;
      width: 100%; }
  .owl-carousel .owl-dots.disabled, .owl-carousel .owl-nav.disabled {
    display: none; }

.no-js .owl-carousel {
  display: block; }

.owl-carousel.owl-loaded {
  display: block; }
.owl-carousel .owl-dot {
  cursor: pointer;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
.owl-carousel .owl-nav .owl-next, .owl-carousel .owl-nav .owl-prev {
  cursor: pointer;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
.owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev {
  background: 0 0;
  color: inherit;
  border: none;
  padding: 0 !important; }
.owl-carousel button.owl-dot {
  background: 0 0;
  color: inherit;
  border: none;
  padding: 0 !important; }
.owl-carousel.owl-loading {
  opacity: 0;
  display: block; }
.owl-carousel.owl-hidden {
  opacity: 0; }
.owl-carousel.owl-refresh .owl-item {
  visibility: hidden; }
.owl-carousel.owl-drag .owl-item {
  -ms-touch-action: pan-y;
  touch-action: pan-y;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none; }
.owl-carousel.owl-grab {
  cursor: move;
  cursor: grab; }
.owl-carousel.owl-rtl {
  direction: rtl; }
  .owl-carousel.owl-rtl .owl-item {
    float: right; }
.owl-carousel .animated {
  animation-duration: 1s;
  animation-fill-mode: both; }
.owl-carousel .owl-animated-in {
  z-index: 0; }
.owl-carousel .owl-animated-out {
  z-index: 1; }
.owl-carousel .fadeOut {
  animation-name: fadeOut; }

@keyframes fadeOut {
  0% {
    opacity: 1; }
  100% {
    opacity: 0; } }
.owl-height {
  transition: height .5s ease-in-out; }

.owl-carousel .owl-item .owl-lazy {
  opacity: 0;
  transition: opacity .4s ease; }
  .owl-carousel .owl-item .owl-lazy:not([src]), .owl-carousel .owl-item .owl-lazy[src^=""] {
    max-height: 0; }
.owl-carousel .owl-item img.owl-lazy {
  transform-style: preserve-3d; }
.owl-carousel .owl-video-wrapper {
  position: relative;
  height: 100%;
  background: #000; }
.owl-carousel .owl-video-play-icon {
  position: absolute;
  height: 80px;
  width: 80px;
  left: 50%;
  top: 50%;
  margin-left: -40px;
  margin-top: -40px;
  background: url(owl.video.play.html) no-repeat;
  cursor: pointer;
  z-index: 1;
  -webkit-backface-visibility: hidden;
  transition: transform .1s ease; }
  .owl-carousel .owl-video-play-icon:hover {
    -ms-transform: scale(1.3, 1.3);
    transform: scale(1.3, 1.3); }
.owl-carousel .owl-video-playing .owl-video-play-icon, .owl-carousel .owl-video-playing .owl-video-tn {
  display: none; }
.owl-carousel .owl-video-tn {
  opacity: 0;
  height: 100%;
  background-position: center center;
  background-repeat: no-repeat;
  background-size: contain;
  transition: opacity .4s ease; }
.owl-carousel .owl-video-frame {
  position: relative;
  z-index: 1;
  height: 100%;
  width: 100%; }

.owl-theme .owl-dots {
  text-align: center;
  -webkit-tap-highlight-color: transparent; }
.owl-theme .owl-nav {
  text-align: center;
  -webkit-tap-highlight-color: transparent;
  margin-top: 10px; }
  .owl-theme .owl-nav [class*=owl-] {
    color: #FFF;
    font-size: 18px;
    margin: 5px;
    padding: 4px 7px;
    background: #D6D6D6;
    display: inline-block;
    cursor: pointer;
    border-radius: 3px; }
    .owl-theme .owl-nav [class*=owl-]:hover {
      background: #869791;
      color: #FFF;
      text-decoration: none; }
  .owl-theme .owl-nav .disabled {
    opacity: .5;
    cursor: default; }
  .owl-theme .owl-nav.disabled + .owl-dots {
    margin-top: 10px; }
.owl-theme .owl-dots .owl-dot {
  display: inline-block;
  zoom: 1; }
  .owl-theme .owl-dots .owl-dot span {
    width: 10px;
    height: 10px;
    margin: 5px 7px;
    background: #D6D6D6;
    display: block;
    -webkit-backface-visibility: visible;
    transition: opacity .2s ease;
    border-radius: 30px; }
  .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
    background: #869791; }

/* Owl Carousel Responsive Image */
.owl-img-responsive .owl-wrapper, .owl-img-responsive .owl-stage {
  display: flex !important; }
  .owl-img-responsive .owl-wrapper .item, .owl-img-responsive .owl-stage .item {
    height: 100%; }
.owl-img-responsive .owl-item img.img-fluid {
  width: 100%;
  height: 100%;
  object-fit: cover;
  max-width: initial; }

/* Magnific Popup CSS */
.mfp-bg {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1042;
  overflow: hidden;
  position: fixed;
  background: #0b0b0b;
  opacity: 0.8; }

.mfp-wrap {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1043;
  position: fixed;
  outline: none !important;
  -webkit-backface-visibility: hidden; }

.mfp-container {
  text-align: center;
  position: absolute;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 0 8px;
  box-sizing: border-box; }
  .mfp-container:before {
    content: '';
    display: inline-block;
    height: 100%;
    vertical-align: middle; }

.mfp-align-top .mfp-container:before {
  display: none; }

.mfp-content {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  margin: 0 auto;
  text-align: left;
  z-index: 1045; }

.mfp-inline-holder .mfp-content, .mfp-ajax-holder .mfp-content {
  width: 100%;
  cursor: auto; }

.mfp-ajax-cur {
  cursor: progress; }

.mfp-zoom-out-cur {
  cursor: -moz-zoom-out;
  cursor: -webkit-zoom-out;
  cursor: zoom-out; }
  .mfp-zoom-out-cur .mfp-image-holder .mfp-close {
    cursor: -moz-zoom-out;
    cursor: -webkit-zoom-out;
    cursor: zoom-out; }

.mfp-zoom {
  cursor: pointer;
  cursor: -webkit-zoom-in;
  cursor: -moz-zoom-in;
  cursor: zoom-in; }

.mfp-auto-cursor .mfp-content {
  cursor: auto; }

.mfp-close, .mfp-arrow, .mfp-preloader, .mfp-counter {
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none; }

.mfp-loading.mfp-figure {
  display: none; }

.mfp-hide {
  display: none !important; }

.mfp-preloader {
  color: #CCC;
  position: absolute;
  top: 50%;
  width: auto;
  text-align: center;
  margin-top: -0.8em;
  left: 8px;
  right: 8px;
  z-index: 1044; }
  .mfp-preloader a {
    color: #CCC; }
    .mfp-preloader a:hover {
      color: #FFF; }

.mfp-s-ready .mfp-preloader, .mfp-s-error .mfp-content {
  display: none; }

button.mfp-close, button.mfp-arrow {
  overflow: visible;
  cursor: pointer;
  background: transparent;
  border: 0;
  -webkit-appearance: none;
  display: block;
  outline: none;
  padding: 0;
  z-index: 1046;
  box-shadow: none;
  touch-action: manipulation; }
button::-moz-focus-inner {
  padding: 0;
  border: 0; }

.mfp-close {
  width: 44px;
  height: 44px;
  line-height: 44px;
  position: absolute;
  right: 0;
  top: 0;
  text-decoration: none;
  text-align: center;
  opacity: 0.65;
  padding: 0 0 18px 10px;
  color: #FFF;
  font-style: normal;
  font-size: 28px;
  font-family: Arial, Baskerville, monospace; }
  .mfp-close:hover, .mfp-close:focus {
    opacity: 1; }
  .mfp-close:active {
    top: 1px; }

.mfp-close-btn-in .mfp-close {
  color: #333; }

.mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close {
  color: #FFF;
  right: -6px;
  text-align: right;
  padding-right: 6px;
  width: 100%; }

.mfp-counter {
  position: absolute;
  top: 0;
  right: 0;
  color: #CCC;
  font-size: 12px;
  line-height: 18px;
  white-space: nowrap; }

.mfp-arrow {
  position: absolute;
  opacity: 0.65;
  margin: 0;
  top: 50%;
  margin-top: -55px;
  padding: 0;
  width: 90px;
  height: 110px;
  -webkit-tap-highlight-color: transparent; }
  .mfp-arrow:active {
    margin-top: -54px; }
  .mfp-arrow:hover, .mfp-arrow:focus {
    opacity: 1; }
  .mfp-arrow:before {
    content: '';
    display: block;
    width: 0;
    height: 0;
    position: absolute;
    left: 0;
    top: 0;
    margin-top: 35px;
    margin-left: 35px;
    border: medium inset transparent; }
  .mfp-arrow:after {
    content: '';
    display: block;
    width: 0;
    height: 0;
    position: absolute;
    left: 0;
    top: 0;
    margin-top: 35px;
    margin-left: 35px;
    border: medium inset transparent;
    border-top-width: 13px;
    border-bottom-width: 13px;
    top: 8px; }
  .mfp-arrow:before {
    border-top-width: 21px;
    border-bottom-width: 21px;
    opacity: 0.7; }

.mfp-arrow-left {
  left: 0; }
  .mfp-arrow-left:after {
    border-right: 17px solid #FFF;
    margin-left: 31px; }
  .mfp-arrow-left:before {
    margin-left: 25px;
    border-right: 27px solid #3F3F3F; }

.mfp-arrow-right {
  right: 0; }
  .mfp-arrow-right:after {
    border-left: 17px solid #FFF;
    margin-left: 39px; }
  .mfp-arrow-right:before {
    border-left: 27px solid #3F3F3F; }

.mfp-iframe-holder {
  padding-top: 40px;
  padding-bottom: 40px; }
  .mfp-iframe-holder .mfp-content {
    line-height: 0;
    width: 100%;
    max-width: 900px; }
  .mfp-iframe-holder .mfp-close {
    top: -40px; }

.mfp-iframe-scaler {
  width: 100%;
  height: 0;
  overflow: hidden;
  padding-top: 56.25%; }
  .mfp-iframe-scaler iframe {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    background: #000; }

/* Main image in popup */
img.mfp-img {
  width: auto;
  max-width: 100%;
  height: auto;
  display: block;
  line-height: 0;
  box-sizing: border-box;
  padding: 40px 0 40px;
  margin: 0 auto; }

/* The shadow behind the image */
.mfp-figure {
  line-height: 0; }
  .mfp-figure:after {
    content: '';
    position: absolute;
    left: 0;
    top: 40px;
    bottom: 40px;
    display: block;
    right: 0;
    width: auto;
    height: auto;
    z-index: -1;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    background: #444; }
  .mfp-figure small {
    color: #BDBDBD;
    display: block;
    font-size: 12px;
    line-height: 14px; }
  .mfp-figure figure {
    margin: 0; }

.mfp-bottom-bar {
  margin-top: -36px;
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  cursor: auto; }

.mfp-title {
  text-align: left;
  line-height: 18px;
  color: #F3F3F3;
  word-wrap: break-word;
  padding-right: 36px; }

.mfp-image-holder .mfp-content {
  max-width: 100%; }

.mfp-gallery .mfp-image-holder .mfp-figure {
  cursor: pointer; }

@media screen and (max-width: 800px) and (orientation: landscape), screen and (max-height: 300px) {
  /**
       * Remove all paddings around the image on small screen
       */
  .mfp-img-mobile .mfp-image-holder {
    padding-left: 0;
    padding-right: 0; }
  .mfp-img-mobile img.mfp-img {
    padding: 0; }
  .mfp-img-mobile .mfp-figure:after {
    top: 0;
    bottom: 0; }
  .mfp-img-mobile .mfp-figure small {
    display: inline;
    margin-left: 5px; }
  .mfp-img-mobile .mfp-bottom-bar {
    background: rgba(0, 0, 0, 0.6);
    bottom: 0;
    margin: 0;
    top: auto;
    padding: 3px 5px;
    position: fixed;
    box-sizing: border-box; }
    .mfp-img-mobile .mfp-bottom-bar:empty {
      padding: 0; }
  .mfp-img-mobile .mfp-counter {
    right: 5px;
    top: 3px; }
  .mfp-img-mobile .mfp-close {
    top: 0;
    right: 0;
    width: 35px;
    height: 35px;
    line-height: 35px;
    background: rgba(0, 0, 0, 0.6);
    position: fixed;
    text-align: center;
    padding: 0; } }
@media all and (max-width: 900px) {
  .mfp-arrow {
    -webkit-transform: scale(0.75);
    transform: scale(0.75); }

  .mfp-arrow-left {
    -webkit-transform-origin: 0;
    transform-origin: 0; }

  .mfp-arrow-right {
    -webkit-transform-origin: 100%;
    transform-origin: 100%; }

  .mfp-container {
    padding-left: 6px;
    padding-right: 6px; } }
/*     Responsive     */
@media screen and (max-width: 576px) {
  .row-card-no-pd [class*=col-] .card:before {
    width: calc(100% - 30px) !important;
    right: 15px !important;
    height: 1px !important; }
  .row-card-no-pd [class*=col-]:first-child .card:before {
    display: none !important; } }
@media screen and (min-width: 991px) {
  .main-panel.full-height > .container, .main-panel.full-height > .container-full {
    margin-top: 0; }
  .main-panel.full-height .navbar-header {
    min-height: 62px; }

  .logo-header {
    line-height: 57px; }

  .toggle-nav-search {
    display: none; }

  #search-nav {
    display: block !important; }

  .sidebar .scroll-element {
    opacity: 0;
    transition: all .2s; }
  .sidebar:hover .scroll-element {
    opacity: 1; }

  .sidebar[data-background-color]:before {
    background: rgba(255, 255, 255, 0.2) !important;
    z-index: 1000; } }
@media screen and (max-width: 991px) {
  .main-header[data-background-color] .navbar-header {
    border-top: 1px solid rgba(0, 0, 0, 0.1); }

  .sidebar {
    position: fixed;
    left: 0 !important;
    right: 0;
    -webkit-transform: translate3d(-270px, 0, 0);
    -moz-transform: translate3d(-270px, 0, 0);
    -o-transform: translate3d(-270px, 0, 0);
    -ms-transform: translate3d(-270px, 0, 0);
    transform: translate3d(-270px, 0, 0) !important;
    transition: all .5s;
    margin-top: 0px; }
    .sidebar:before {
      background: none; }

  .nav_open .sidebar {
    -webkit-transform: translate3d(0px, 0, 0);
    -moz-transform: translate3d(0px, 0, 0);
    -o-transform: translate3d(0px, 0, 0);
    -ms-transform: translate3d(0px, 0, 0);
    transform: translate3d(0px, 0, 0) !important;
    border-right: 1px solid #f1f1f1; }

  .sidebar .sidebar-wrapper {
    padding-top: 0px; }
    .sidebar .sidebar-wrapper .sidebar-content {
      padding-top: 0px !important; }
    .sidebar .sidebar-wrapper .scroll-element.scroll-y {
      top: 0px !important; }

  .nav_open {
    overflow: hidden !important; }
    .nav_open .wrapper {
      overflow-x: hidden; }
    .nav_open .main-panel, .nav_open .main-header {
      -webkit-transform: translate3d(250px, 0, 0);
      -moz-transform: translate3d(250px, 0, 0);
      -o-transform: translate3d(250px, 0, 0);
      -ms-transform: translate3d(250px, 0, 0);
      transform: translate3d(250px, 0, 0) !important; }

  .quick_sidebar_open .quick-sidebar {
    width: 350px; }

  .main-header {
    transition: all .5s; }

  #search-nav {
    margin: 0 auto !important; }

  .main-panel {
    width: 100%;
    transition: all .5s; }
    .main-panel .page-header .dropdown-menu:after {
      right: 16px !important; }

  .page-inner {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto; }

  .page-sidebar {
    background: #fff; }

  .logo-header {
    display: flex;
    width: 100% !important;
    text-align: left;
    position: relative;
    padding-left: 15px;
    padding-right: 15px; }
    .logo-header .logo {
      position: absolute;
      left: 50%;
      transform: translateX(-50%); }
    .logo-header .navbar-toggler {
      height: 100%;
      margin-left: 0px !important;
      opacity: 1;
      display: block;
      order: 1; }
    .logo-header .more {
      opacity: 1;
      color: #545454;
      cursor: pointer;
      display: inline-block;
      line-height: 56px;
      order: 3;
      width: unset;
      margin-left: auto; }
    .logo-header .navbar-brand {
      position: unset !important;
      margin-right: 0px; }

  .topbar_open .logo-header {
    border-bottom: 2px solid rgba(255, 255, 255, 0.1); }

  .nav-search {
    width: 100%;
    margin-right: 0 !important; }

  .navbar-header {
    position: absolute;
    width: 100%;
    transform: translate3d(0, -200px, 0) !important;
    transition: all .5s; }

  .topbar_open .navbar-header {
    transform: translate3d(0, 61px, 0) !important; }
    .topbar_open .navbar-header .navbar-nav > .nav-item .nav-link i {
      font-size: 16px; }
    .topbar_open .navbar-header .navbar-nav > .nav-item:last-child .nav-link {
      padding: 0px !important; }
    .topbar_open .navbar-header .navbar-nav > .nav-item:last-child .quick-sidebar-toggler {
      padding-left: 5px !important; }
  .topbar_open .toggle-nav-search {
    display: list-item; }
  .topbar_open #search-nav {
    text-align: center;
    width: 100%;
    padding: 10px 15px 0px;
    order: 1; }
  .topbar_open .main-panel {
    transform: translate3d(0, 62px, 0) !important; }
  .topbar_open > .content {
    margin-top: 0px !important; }

  .nav_open.topbar_open .main-panel {
    transform: translate3d(250px, 60px, 0) !important; }

  .navbar-header .navbar-nav {
    width: 100%;
    flex-direction: row;
    justify-content: center;
    margin-left: 0px !important;
    position: relative; }
    .navbar-header .navbar-nav .dropdown {
      position: unset; }
    .navbar-header .navbar-nav .dropdown-menu {
      position: absolute;
      left: 0;
      right: 0;
      margin: 0 auto;
      max-width: 280px; }

  .profile-pic span {
    display: none; }

  .nav-toggle {
    display: none; }

  .page-title {
    font-size: 18px; }

  .card .card-title {
    font-size: 18px; }

  .mail-wrapper .mail-option .email-filters-left {
    width: 50%; }
    .mail-wrapper .mail-option .email-filters-left .btn-group {
      margin-bottom: 10px; }

  /* Dropzone */
  .dropzone {
    padding: 20px 15px !important; }
    .dropzone .dz-message .message {
      font-size: 23px; }
    .dropzone .dz-message .note {
      font-size: 15px; } }
@media screen and (min-width: 856px) {
  .mail-wrapper .aside-nav {
    display: block !important; } }
@media screen and (max-width: 856px) {
  .mail-wrapper {
    flex-direction: column; }
    .mail-wrapper .page-aside {
      width: 100%;
      height: unset;
      min-height: unset;
      border-bottom: 1px solid #eee;
      border-left: 0;
      border-right: 0;
      background: transparent;
      padding-top: 0px;
      padding-bottom: 0px; }
      .mail-wrapper .page-aside .aside-header {
        padding-top: 25px;
        padding-bottom: 25px;
        background: #f1f1f1; }
      .mail-wrapper .page-aside .aside-nav {
        background: #ffffff;
        padding-top: 15px;
        padding-bottom: 15px; }
    .mail-wrapper .mail-content {
      width: 100%; }
      .mail-wrapper .mail-content .inbox-head {
        flex-direction: column;
        align-items: left; }
        .mail-wrapper .mail-content .inbox-head h3 {
          font-size: 18px; }
        .mail-wrapper .mail-content .inbox-head form {
          margin-left: 0px !important;
          margin-top: 15px; }
      .mail-wrapper .mail-content .email-head h3 {
        font-size: 18px; }
      .mail-wrapper .mail-content .email-compose-fields {
        padding: 20px 15px; }
    .mail-wrapper .mail-option {
      flex-direction: column; }
      .mail-wrapper .mail-option .email-filters-left {
        width: 100%;
        margin-bottom: 10px; }
    .mail-wrapper .toggle-email-nav {
      display: inline-block !important; }
    .mail-wrapper .table-inbox tr td .badge {
      margin-top: 5px;
      float: left; } }
@media screen and (max-width: 767px) {
  .wizard-container {
    margin-left: 15px;
    margin-right: 15px; }

  .main-panel .page-header {
    flex-direction: column;
    align-items: normal;
    position: relative;
    min-height: 43px;
    justify-content: center; }
    .main-panel .page-header .breadcrumbs {
      margin-left: 0px;
      padding-top: 15px;
      padding-left: 5px;
      padding-bottom: 0px;
      border-left: 0px; }
    .main-panel .page-header .btn-group-page-header {
      position: absolute;
      right: 0px; }

  .footer .container-fluid {
    flex-direction: column; }
    .footer .container-fluid .copyright {
      margin-left: 0 !important;
      margin-top: 10px;
      margin-bottom: 15px; } }
@media screen and (max-width: 576px) {
  #chart-container {
    min-height: 250px; }

  .form-check-inline {
    display: flex;
    flex-direction: column;
    align-items: left; }

  #calendar .fc-toolbar {
    display: flex;
    flex-direction: column; }
    #calendar .fc-toolbar .fc-left, #calendar .fc-toolbar .fc-right, #calendar .fc-toolbar .fc-center {
      margin: auto;
      margin-bottom: 15px; }
    #calendar .fc-toolbar .fc-left {
      order: 1; }
    #calendar .fc-toolbar .fc-right {
      order: 3; }
    #calendar .fc-toolbar .fc-center {
      order: 2; }

  .conversations .conversations-body {
    padding: 1.5rem 1rem; } }
@media screen and (max-width: 350px) {
  .quick_sidebar_open .quick-sidebar {
    width: 100%;
    padding: 20px; } }
/*     	Login     */
.login {
  background: #efefee; }
  .login .wrapper.wrapper-login {
    display: flex;
    justify-content: center;
    align-items: center;
    height: unset;
    padding: 15px; }
    .login .wrapper.wrapper-login .container-login, .login .wrapper.wrapper-login .container-signup {
      width: 400px;
      padding: 60px 25px;
      border-radius: 5px; }
      .login .wrapper.wrapper-login .container-login:not(.container-transparent), .login .wrapper.wrapper-login .container-signup:not(.container-transparent) {
        background: #ffffff;
        -webkit-box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        -moz-box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        border: 1px solid #ebecec; }
      .login .wrapper.wrapper-login .container-login h3, .login .wrapper.wrapper-login .container-signup h3 {
        font-size: 19px;
        font-weight: 600;
        margin-bottom: 25px; }
      .login .wrapper.wrapper-login .container-login .form-sub, .login .wrapper.wrapper-login .container-signup .form-sub {
        align-items: center;
        justify-content: space-between;
        padding: 8px 10px; }
      .login .wrapper.wrapper-login .container-login .btn-login, .login .wrapper.wrapper-login .container-signup .btn-login {
        padding: 15px 0;
        width: 135px; }
      .login .wrapper.wrapper-login .container-login .form-action, .login .wrapper.wrapper-login .container-signup .form-action {
        text-align: center;
        padding: 25px 10px 0; }
      .login .wrapper.wrapper-login .container-login .form-action-d-flex, .login .wrapper.wrapper-login .container-signup .form-action-d-flex {
        display: flex;
        align-items: center;
        justify-content: space-between; }
      .login .wrapper.wrapper-login .container-login .login-account, .login .wrapper.wrapper-login .container-signup .login-account {
        padding-top: 10px;
        text-align: center; }
    .login .wrapper.wrapper-login .container-signup .form-action {
      display: flex;
      justify-content: center; }
  .login .wrapper.wrapper-login-full {
    justify-content: unset;
    align-items: unset;
    padding: 0 !important; }
  .login .login-aside {
    padding: 25px; }
    .login .login-aside .title {
      font-size: 36px; }
    .login .login-aside .subtitle {
      font-size: 18px; }
  .login .show-password {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    cursor: pointer; }
  .login .custom-control-label {
    white-space: nowrap; }

@media screen and (max-width: 576px) {
  .form-action-d-flex {
    flex-direction: column;
    align-items: start !important; }

  .login .wrapper-login-full {
    flex-direction: column; }
  .login .login-aside {
    width: 100% !important; }
    .login .login-aside .title {
      font-size: 24px; }
    .login .login-aside .subtitle {
      font-size: 16px; } }
@media screen and (max-width: 399px) {
  .wrapper-login {
    padding: 15px !important; }

  .container-login {
    width: 100% !important;
    padding: 60px 15px !important; } }
/*     	Page 404     */
.page-not-found {
  background-image: url("../img/bg-404.jpg");
  background-size: cover;
  background-position: center;
  image-rendering: pixelated; }
  .page-not-found .wrapper.not-found {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: #ffffff;
    background: rgba(0, 0, 0, 0.61); }
    .page-not-found .wrapper.not-found h1 {
      font-size: 100px;
      letter-spacing: .15em;
      font-weight: 600;
      animation-delay: .5s; }
    .page-not-found .wrapper.not-found .desc {
      font-size: 27px;
      text-align: center;
      line-height: 50px;
      animation-delay: 1.5s;
      letter-spacing: 2px; }
      .page-not-found .wrapper.not-found .desc span {
        font-weight: 600;
        font-size: 30px; }
    .page-not-found .wrapper.not-found .btn-back-home {
      border-radius: 50px;
      padding: 13px 25px;
      animation-delay: 2.5s; }

@media screen and (max-width: 576px) {
  .wrapper.not-found h1 {
    font-size: 65px !important; }
  .wrapper.not-found .desc {
    font-size: 18px !important; } }
/* 	 Background Body */
body {
  background: #f9fbfd; }
  body[data-background-color="bg1"] {
    background: #f9fbfd; }
  body[data-background-color="bg2"] {
    background: #ffffff; }
  body[data-background-color="bg3"] {
    background: #f1f1f1; }
  body[data-background-color="dark"] {
    background: #1a2035; }
    body[data-background-color="dark"] .main-header {
      box-shadow: 0px 0px 5px #121727; }
    body[data-background-color="dark"] .main-panel {
      color: rgba(169, 175, 187, 0.82) !important; }
      body[data-background-color="dark"] .main-panel label {
        color: #fff !important; }
    body[data-background-color="dark"] .card, body[data-background-color="dark"] .row-card-no-pd, body[data-background-color="dark"] .list-group-item, body[data-background-color="dark"] .timeline > li > .timeline-panel {
      background: #202940; }
    body[data-background-color="dark"] .card-pricing2 {
      background: #202940 !important; }
    body[data-background-color="dark"] .row-card-no-pd [class*=col] .card:before {
      background: rgba(181, 181, 181, 0.1) !important; }
    body[data-background-color="dark"] .card .card-header, body[data-background-color="dark"] .card .card-footer, body[data-background-color="dark"] .card .card-action, body[data-background-color="dark"] .card-profile .user-stats [class^="col"], body[data-background-color="dark"] .timeline > li > .timeline-panel, body[data-background-color="dark"] .table td, body[data-background-color="dark"] .table th, body[data-background-color="dark"] .breadcrumbs, body[data-background-color="dark"] .separator-dashed, body[data-background-color="dark"] .separator-solid, body[data-background-color="dark"] .separator-dot, body[data-background-color="dark"] .list-group .list-group-item, body[data-background-color="dark"] .conversations .messages-form, body[data-background-color="dark"] .mail-wrapper .mail-content .inbox-body .email-list .email-list-item, body[data-background-color="dark"] .page-with-aside .page-aside, body[data-background-color="dark"] .mail-wrapper .mail-content .email-head, body[data-background-color="dark"] .mail-wrapper .mail-content .email-sender, body[data-background-color="dark"] .main-panel .page-divider {
      border-color: rgba(181, 181, 181, 0.1) !important; }
    body[data-background-color="dark"] .timeline > li > .timeline-panel:before {
      border-left-color: rgba(181, 181, 181, 0.1);
      border-right-color: rgba(181, 181, 181, 0.1); }
    body[data-background-color="dark"] .timeline > li > .timeline-panel:after {
      border-left-color: #202940;
      border-right-color: #202940; }
    body[data-background-color="dark"] .page-title, body[data-background-color="dark"] .breadcrumbs li a {
      color: rgba(169, 175, 187, 0.82); }
    body[data-background-color="dark"] .page-category {
      color: #828282; }
    body[data-background-color="dark"] .card-title, body[data-background-color="dark"] .card-title a, body[data-background-color="dark"] .card-title a:hover, body[data-background-color="dark"] .card-title a:focus {
      color: #fff; }
    body[data-background-color="dark"] .card-category {
      color: #8b92a9; }
    body[data-background-color="dark"] .card-black, body[data-background-color="dark"] .card-primary, body[data-background-color="dark"] .card-secondary, body[data-background-color="dark"] .card-info, body[data-background-color="dark"] .card-success, body[data-background-color="dark"] .card-warning, body[data-background-color="dark"] .card-danger {
      color: #fff; }
      body[data-background-color="dark"] .card-black .card-title, body[data-background-color="dark"] .card-black .card-category, body[data-background-color="dark"] .card-primary .card-title, body[data-background-color="dark"] .card-primary .card-category, body[data-background-color="dark"] .card-secondary .card-title, body[data-background-color="dark"] .card-secondary .card-category, body[data-background-color="dark"] .card-info .card-title, body[data-background-color="dark"] .card-info .card-category, body[data-background-color="dark"] .card-success .card-title, body[data-background-color="dark"] .card-success .card-category, body[data-background-color="dark"] .card-warning .card-title, body[data-background-color="dark"] .card-warning .card-category, body[data-background-color="dark"] .card-danger .card-title, body[data-background-color="dark"] .card-danger .card-category {
        color: #fff; }
    body[data-background-color="dark"] .nav-pills .nav-link:not(.active) {
      background: #fff; }
    body[data-background-color="dark"] .card-pricing .specification-list li {
      border-color: #373d4c; }
    body[data-background-color="dark"] .input-group-text {
      border-color: #2f374b !important;
      background-color: #1f283e;
      color: #fff; }
    body[data-background-color="dark"] .input-solid {
      background: #363b4c !important;
      border-color: #363b4c !important; }
    body[data-background-color="dark"] .list-group-messages .list-group-item-title a, body[data-background-color="dark"] .list-group .list-group-item-text {
      color: inherit; }
    body[data-background-color="dark"] .footer {
      border-top: 1px solid #293247;
      background: #1f283e; }
    body[data-background-color="dark"] .form-control, body[data-background-color="dark"] .form-group-default, body[data-background-color="dark"] .select2-container--bootstrap .select2-selection {
      background-color: #1a2035;
      color: #fff;
      border-color: #2f374b; }
    body[data-background-color="dark"] .bootstrap-tagsinput {
      background: transparent; }
    body[data-background-color="dark"] .selectgroup-button {
      border: 1px solid #2f374b; }
    body[data-background-color="dark"] .conversations .message-header {
      background: #1a2035;
      box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.07); }
    body[data-background-color="dark"] .conversations .conversations-content {
      color: #575962;
      border-color: #2e364a; }
    body[data-background-color="dark"] .mail-wrapper .mail-content .inbox-body .email-list .email-list-item.unread {
      background: #1f283e !important; }
    body[data-background-color="dark"] .mail-wrapper .mail-content .inbox-body .email-list .email-list-item:hover {
      background: #171e2f !important; }
    body[data-background-color="dark"] .page-with-aside .page-aside .aside-nav .nav > li:hover, body[data-background-color="dark"] .page-with-aside .page-aside .aside-nav .nav > li:focus, body[data-background-color="dark"] .page-with-aside .page-aside .aside-nav .nav > li.active {
      background: rgba(0, 0, 0, 0.03); }
    body[data-background-color="dark"] .page-with-aside .page-aside .aside-nav .nav > li.active > a {
      color: #b9babf !important; }
    body[data-background-color="dark"] .board {
      color: #575962; }

/*   Background   */
.bg-transparent {
  background: transparent !important; }

.bg-black {
  background-color: #1a2035 !important; }

.bg-black2 {
  background-color: #1f283e !important; }

.bg-primary {
  background-color: #1572E8 !important; }

.bg-primary2 {
  background-color: #1269DB !important; }

.bg-secondary {
  background-color: #6861CE !important; }

.bg-secondary2 {
  background-color: #5C55BF !important; }

.bg-info {
  background-color: #48ABF7 !important; }

.bg-info2 {
  background-color: #3697E1 !important; }

.bg-success {
  background-color: #31CE36 !important; }

.bg-success2 {
  background-color: #2BB930 !important; }

.bg-warning {
  background-color: #FFAD46 !important; }

.bg-warning2 {
  background-color: #FF9E27 !important; }

.bg-danger {
  background-color: #F25961 !important; }

.bg-danger2 {
  background-color: #EA4d56 !important; }

.bg-grey1 {
  background: #f9fbfd !important; }

.bg-grey2 {
  background: #f1f1f1 !important; }

.bg-black-gradient {
  background: #1f283e !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #0A0B11, #1f283e) !important;
  background: linear-gradient(-45deg, #0A0B11, #1f283e) !important; }

.bg-primary-gradient {
  background: #1572E8 !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #06418E, #1572E8) !important;
  background: linear-gradient(-45deg, #06418E, #1572E8) !important; }

.bg-secondary-gradient {
  background: #6861CE !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #2A20AC, #6861CE) !important;
  background: linear-gradient(-45deg, #2A20AC, #6861CE) !important; }

.bg-info-gradient {
  background: #48ABF7 !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #0A5A97, #48ABF7) !important;
  background: linear-gradient(-45deg, #0A5A97, #48ABF7) !important; }

.bg-success-gradient {
  background: #31CE36 !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #179D08, #31CE36) !important;
  background: linear-gradient(-45deg, #179D08, #31CE36) !important; }

.bg-warning-gradient {
  background: #FFAD46 !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #E1810B, #FFAD46) !important;
  background: linear-gradient(-45deg, #E1810B, #FFAD46) !important; }

.bg-danger-gradient {
  background: #F25961 !important;
  background: -webkit-linear-gradient(legacy-direction(-45deg), #E80A15, #F25961) !important;
  background: linear-gradient(-45deg, #E80A15, #F25961) !important; }

/*# sourceMappingURL=atlantis.css.map */


/*=== custom ==*/

.content
{
  margin-top: 3.5%;
}
</style>
