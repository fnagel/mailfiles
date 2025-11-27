<?php

namespace FelixNagel\Mailfiles\Updates;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard(CTypeMigration::class)]
class CTypeMigration extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return ['mailfiles_pi1' => 'mailfiles_pi1'];
    }

    public function getTitle(): string
    {
        return 'Migrate "mailfiles" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return 'The "mailfiles" plugin is now registered as content element.'.
            ' Update migrates existing records and backend user permissions.';
    }
}
