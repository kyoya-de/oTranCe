<?php
/**
 * This file is part of oTranCe released under the GNU GPL 2 license
 * http://www.oTranCe.de
 *
 * @package         oTranCe
 * @subpackage      Models
 * @version         SVN: $
 * @author          $Author$
 */

/**
 * History model
 *
 * @package         oTranCe
 * @subpackage      Models
 */
class Application_Model_History extends Msd_Application_Model
{
    /**
     * Name of table containing history data
     *
     * @var string
     */
    private $_tableHistory;

    /**
     * Database table containing language keys.
     *
     * @var string
     */
    private $_tableKeys;

    /**
     * Database table containing translations.
     *
     * @var string
     */
    private $_tableTranslations;

    /**
     * Model initialization method.
     *
     * @return void
     */
    public function init()
    {
        $this->_tableHistory      = $this->_tablePrefix . 'history';
        $this->_tableKeys         = $this->_tablePrefix . 'keys';
        $this->_tableTranslations = $this->_tablePrefix . 'translations';
    }

    /**
     * Get entries from history table
     *
     * @param int    $offset         Records to bypass
     * @param int    $nr             Number of records to return
     * @param int    $filterLanguage Id of language to filter
     * @param int    $filterUser     Id of user to filter
     * @param string $filterAction   Action to filter
     *
     * @return array
     */
    public function getEntries($offset = 0, $nr = 50, $filterLanguage = 0, $filterUser = 0, $filterAction = '')
    {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS h.*, k.`id` as `key_id`, k.`key` FROM `' . $this->_tableHistory . '` h ';
        $sql .= ' LEFT JOIN `' . $this->_tableKeys . '` k ON h.`key_id` = k.`id`';
        $sql .= ' WHERE 1';
        if ($filterLanguage > 0) {
            $sql .= ' AND `lang_id`=' . intval($filterLanguage);
        }
        if ($filterUser > 0) {
            $sql .= ' AND `user_id`=\'' . $filterUser . '\'';
        }
        if ($filterAction != '0' && $filterAction > '') {
            if (strpos($filterAction, '%') !== false) {
                $sql .= ' AND `action` LIKE \'' . $filterAction . '\'';
            } else {
                if ($filterAction > '') {
                    $sql .= ' AND `action`=\'' . $filterAction . '\'';
                }
            }
        }
        $sql .= ' ORDER BY `dt` DESC LIMIT ' . $offset . ',' . $nr;

        return $this->_dbo->query($sql, Msd_Db::ARRAY_ASSOC, true);
    }

    /**
     * Compare old with new values and log changes
     *
     * @param string $keyId     Id of key
     * @param array  $oldValues Old translations
     * @param array  $newValues New translations
     *
     * @return void
     */
    public function logChanges($keyId, $oldValues, $newValues)
    {
        foreach ($newValues as $langId => $newVal) {
            // if old value wasn't set
            if (!isset($oldValues[$langId])) {
                $oldValues[$langId] = '';
            }

            if ($newVal !== $oldValues[$langId]) {
                $this->_saveChange($keyId, $langId, $oldValues[$langId], $newVal);
            }
        }
    }

    /**
     * Log creation of a new language variable
     *
     * @param string $name Name of key that was created
     *
     * @return void
     */
    public function logNewVarCreated($name)
    {
        $this->_saveChange($name, 0, '', '', 'created');
    }

    /**
     * Log creation of a new language variable
     *
     * @param int    $keyId   Id of key that was changed
     * @param string $oldName Old key name
     * @param string $newName New key name
     *
     * @return void
     */
    public function logVarNameChanged($keyId, $oldName, $newName)
    {
        $this->_saveChange($keyId, 0, $oldName, $newName, 'changed');
    }

    /**
     * Log deletion of a language variable
     *
     * @param string $key Name of key that was deleted
     *
     * @return void
     */
    public function logVarDeleted($key)
    {
        $this->_saveChange(0, 0, '', '', 'deleted \'' . $key . '\'');
    }

    /**
     * Delete entry by id
     *
     * @param int $id Id of history entry
     *
     * @return boolean
     */
    public function deleteById($id)
    {
        $sql = 'DELETE FROM `' . $this->_tableHistory . '` WHERE `id` = ' . intval($id) . ' LIMIT 1';

        return $this->_dbo->query($sql, Msd_Db::SIMPLE);
    }

    /**
     * Get latest edit change of the given language
     *
     * @param string $langId Id of language
     *
     * @return string
     */
    public function getLatestChange($langId)
    {
        $langId = (int)$langId;
        $sql    = 'SELECT MAX(`dt`)  as `latestChange` FROM `' . $this->_tableTranslations . '`'
            . ' WHERE `lang_id`=' . $langId;
        $res    = $this->_dbo->query($sql, Msd_Db::ARRAY_ASSOC);

        return isset($res[0]['latestChange']) ? $res[0]['latestChange'] : '';
    }

    /**
     * Log action login failed
     *
     * @param string $user Name of user that tried to log in
     *
     * @return void
     */
    public function logLoginFailed($user)
    {
        $this->_saveAction(0, $user . ' failed to log in');
    }

    /**
     * Log action login ok
     *
     * @return void
     */
    public function logLoginSuccess()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->_saveAction($auth['id'], 'logged in');
    }

    /**
     * Log action log out
     *
     * @return void
     */
    public function logLogout()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->_saveAction($auth['id'], 'logged out');
    }

    /**
     * Log action vcs update
     *
     * @param int $langId Id of language
     *
     * @return void
     */
    public function logVcsUpdate($langId)
    {
        $this->_saveChange('', $langId, '', '', 'updated VCS');
    }

    /**
     * Log action vcs update for all languages
     *
     * @return void
     */
    public function logVcsUpdateAll()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->_saveAction($auth['id'], 'updated VCS');
    }

    /**
     * Log updating of languaeg packages
     *
     * @return void
     */
    public function logUpdateOfLanguagePacks()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->_saveAction($auth['id'], 'updated language packages');
    }

    /**
     * Log action user registered
     *
     * @param int $userId Id of user
     *
     * @return void
     */
    public function logUserRegistered($userId)
    {
        $this->_saveAction($userId, 'registered');
    }

    /**
     * Log action user account approved
     *
     * @param int $userId Id of user
     *
     * @return void
     */
    public function logUserAccountApproved($userId)
    {
        $auth   = Zend_Auth::getInstance()->getIdentity();
        $action = 'account approved by ' . $auth['name'];
        $this->_saveAction($userId, $action);
    }

    /**
     * Log action user account approved
     *
     * @param int $userId Id of user
     *
     * @return void
     */
    public function logUserAccountClosed($userId)
    {
        $auth   = Zend_Auth::getInstance()->getIdentity();
        $action = 'account closed by ' . $auth['name'];
        $this->_saveAction($userId, $action);
    }

    /**
     * Delete all log entries of a user
     *
     * @param int $userId The Id of the user to delete
     *
     * @return bool
     */
    public function deleteEntriesByUserId($userId)
    {
        $sql = 'DELETE FROM `' . $this->_tableHistory . '` WHERE `user_id` = ' . intval($userId);
        $res = $this->_dbo->query($sql, Msd_Db::SIMPLE);
        $this->_dbo->optimizeTable($this->_tableHistory);

        return (bool)$res;
    }

    /**
     * Save change to history table in database
     *
     * @param string      $keyId  The key to save, 0 if not referring to a key
     * @param string      $langId Id of language
     * @param string      $oldVal The old translation
     * @param string      $newVal The new translation
     * @param string      $action The performed action
     * @param bool|string $time   If false, set current time automatically
     *
     * @return void
     */
    private function _saveChange($keyId, $langId, $oldVal, $newVal, $action = 'changed', $time = false)
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        if ($time == false) {
            $time = date('Y-m-d H-i-s', time());
        }
        $sql = 'INSERT INTO `' . $this->_database . '`.`' . $this->_tableHistory
            . '` (`user_id`, `dt`, `key_id`, `action`, `lang_id`,`oldValue`,`newValue`)'
            . ' VALUES ('
            . intval($auth['id']) . ', '
            . '\'' . $time . '\', '
            . intval($keyId) . ', '
            . '\'' . $this->_dbo->escape($action) . '\', '
            . intval($langId) . ', '
            . '\'' . $this->_dbo->escape($oldVal) . '\', '
            . '\'' . $this->_dbo->escape($newVal) . '\')';
        $this->_dbo->query($sql);
    }

    /**
     * Save action that is not related to a language/key change
     *
     * @param int    $userId The id of the user
     * @param string $action The action to log
     *
     * @return void
     */
    private function _saveAction($userId, $action)
    {
        //TODO normalize action row and get rid of text entries
        $time = date('Y-m-d H-i-s', time());
        $sql  = 'INSERT INTO `' . $this->_database . '`.`' . $this->_tableHistory
            . '` (`user_id`, `dt`, `key_id`, `action`, `lang_id`,`oldValue`,`newValue`)'
            . ' VALUES (' . intval($userId) . ', \'' . $time . '\', 0, '
            . '\'' . $this->_dbo->escape($action) . '\', '
            . '0, \'\', \'\')';
        $this->_dbo->query($sql);
    }

}
