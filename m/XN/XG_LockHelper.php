<?php
/**     $Id: class.php 3530 2006-08-15 14:48:07Z andrew $
 *
 *   Locking functions.
 *   Features:
 *   	- reliable locking (~0% race condition probability)
 *   	- blocking locks (+ timeouts)
 *   	- non-persistent locks, which are are automatically released upon script termination.
 *   	- persistent locks, which are not automatically released but can be expired
 *
 **/

class XG_LockHelper {
	/** @var {lockName:1} 	Acquired non-persistent locks */
    static protected    $locks          = array();

    /** Time between attempts to obtain a lock, in seconds (for blocking locks) */
    static protected    $waitInterval    = 0.1;

    /** Default lock waiting timeout, in seconds. The number of attempts to get lock = waitTimeout / waitInterval */
    static protected    $waitTimeout     = 5;

    /** Maximum lifetime of a non-persistent lock, in seconds. After this time has elapsed, obtained locks are treated as dead and are removed. */
    static protected    $expiredTimeout = 60;

    /** Name of the "repair" lock, obtained when removing an expired lock. */
    static protected    $expiredLockName= 'XG_LockHelper::internal-fg4bwe095buj459v';

	/** The cacher object used for obtaining locks (usually XN_Cache) */
    static protected    $cacher;

    /**
	 *  Initializes lock helper
     *
     *  @return     void
     */
    public static function init() {
		self::$cacher = new XN_Cache;
		register_shutdown_function(__CLASS__.'::_unlockAll');
    }

    /**
     * Allows you to specify the interface to the cache
     *
     * @internal This is currently only used in testing.  This method may
     *           change without warning.
     *
     * @unsupported
     */
    public static function setCacher($cacher) {
        self::$cacher = $cacher;
    }

    /**
	 * Attempts to obtain a non-persistent lock with the given name. Lock will be released upon process termination.
     *
     * @param   $lockName       string  Name of the lock
     * @param	$waitTimeout    float   Wait timeout in seconds. If NULL, default timeout is used. 0 - do not wait
     * @return  boolean                 Whether the lock was successfully obtained
     */
	public static function lock($lockName, $waitTimeout = NULL) {
        if (isset(self::$locks[$lockName])) {
            XG_LogHelper::error_log("Attempt to obtain the already obtained lock `$lockName'. URL is `$_SERVER[REQUEST_URI]'");
            return true;
        }
        $ok = 0;
        $now = microtime(true);
        $retries = intval((NULL === $waitTimeout ? self::$waitTimeout : $waitTimeout) / self::$waitInterval);
        for ($i = 0; $i<=$retries; $i++) {
            if (self::$cacher->insert($lockName, $now)) {
                $ok = 1;
                break;
            }
            if (NULL === ($time = self::$cacher->get($lockName))) {  // Hmm.. Has the record just disappeared? Do not wait!
                continue;
            }
            if ($time < $now - self::$expiredTimeout) { // Is lock expired? Try to obtain the "repair" lock.
                if (!$repair = self::$cacher->insert(self::$expiredLockName, $now)) {    // If we CANNOT obtain the repair lock
                    $rtime = self::$cacher->get(self::$expiredLockName);                 // lets see when this lock was set.
                    if ($rtime && $rtime < $now - self::$expiredTimeout) {          // expired?
                        self::$cacher->remove(self::$expiredLockName);
                        $rtime = 0;
                    }
                    if (!$rtime) {                                                  // disappeared or removed?
                        $repair = self::$cacher->insert(self::$expiredLockName, $now);
                    }
                }
                if ($repair) {
                    if ($time === self::$cacher->get($lockName)) {
                        self::$cacher->remove($lockName);
                        self::$cacher->remove(self::$expiredLockName);
						$i--; // handle the "last retry case" - it doesn't make sense to clean everything up... and return false. [Andrey 2009-02-01]
                        continue;
                    }
                }
                // fallback to the waiting
            }
            if ($i != $retries) { // do not wait on the last step
                usleep(self::$waitInterval*1000000);
            }
        }
		if (!$ok) {
            return false;
        }
        self::$locks[$lockName] = 1;
        return true;
    }

    /**
	 * Attempts to obtain a PERSISTENT lock with the given name. Lock WILL NOT be automatically released upon process termination.
     *
     * @param   $lockName   string  	Name of the lock
	 * @param   $duration   int   		Time to hold the lock for in seconds.
     * @return  boolean                 Whether the lock was successfully obtained
     */
    public static function persistentLock($lockName, $duration = 120) {
		if (self::$cacher->insert($lockName, time() + $duration)) {
			return true;
		}
		if ($then = self::$cacher->get($lockName)) { // the key already exists
			if ($then > time()) { // duration is not expired
				return false;
			}
			// We cannot just remove the key, another process could already replace it with the new one.
			// self::lock also will take care about "hanging" locks
			$repairKey = "$lockName-XG_LockHelper-repair-32409gu4095";
			if (!self::lock($repairKey, 0)) {
				return false;
			}
			// Read it again to check that we still work with the same key
			if (self::$cacher->get($lockName) != $then) {
				self::unlock($repairKey);
				return false;
			}
			// Ok, we can proceed with the deletion.
			try { self::$cacher->remove($lockName); } catch(Exception $e) { }
			//self::unlock($repairKey);
		} else { // the key just disappeared? try to insert it once again
			// do nothing
		}
		// the last chance to obtain the key
		return self::$cacher->insert($lockName, time() + $duration);
    }

    /**
	 * Releases the lock with the given name (both persistent and non-persistent locks)
     *
     * @param   $lockName   string  Name of the lock
     */
    public static function unlock($lockName) { # void
		self::$cacher->remove($lockName);
        if (isset(self::$locks[$lockName])) {
            unset(self::$locks[$lockName]);
        }
    }

    /**
     * Releases all non-persisntent locks. Used to handle unexpected script terminations.
     */
    public static function _unlockAll() { # void
        foreach (self::$locks as $l=>$tmp) {
            self::$cacher->remove($l);
        }
    }
}
XG_LockHelper::init();
?>
