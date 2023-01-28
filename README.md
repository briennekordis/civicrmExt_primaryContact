## Overview
This is an example extenstion for CiviCRM.

When a new Primary Contact relationship is being made for an Organization, this extension makes previous Primary Contacts for that Organization inactive, with an ending date of the creation date of the new relationship so that there is only one Primary Contact per Organization.

## Requirements
* PHP v7.0+
* Tested on CiviCRM 5.71+

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl presentation@https://github.com/briennekordis/civicrmExt_primaryContact/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/briennekordis/civicrmExt_primaryContact.git
cv en primarycontact
```
