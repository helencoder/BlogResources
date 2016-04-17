<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 17:55
 * description: PHP加密函数
 */
class Encryption{
    /*
     * 典型加密函数：
     * md5()
     * sha1()
     * crypt()
     * urlencode()
     * urldecode()
     * base64_encode()
     * */
    /*
     * md5()
     * md5 — Calculate the md5 hash of a string
     * string md5 ( string $str [, bool $raw_output = false ] )
     * Calculates the MD5 hash of str using the ? RSA Data Security, Inc. MD5 Message-Digest Algorithm, and returns that hash.
     * Parameters
        str
        The string.

        raw_output
        If the optional raw_output is set to TRUE, then the md5 digest is instead returned in raw binary format with a length of 16.
     *
     * Return Values
        Returns the hash as a 32-character hexadecimal number.
     * */
    /*
     * sha1()
     * sha1 — Calculate the sha1 hash of a string
     * string sha1 ( string $str [, bool $raw_output = false ] )
     * Parameters ?

        str
        The input string.

        raw_output
        If the optional raw_output is set to TRUE, then the sha1 digest is instead returned in raw binary format with a length of 20, otherwise the returned value is a 40-character hexadecimal number.
     *
     * Return Values ?

        Returns the sha1 hash as a string.
     * */

    /*
     * crypt()
     * crypt — One-way string hashing
     * string crypt ( string $str [, string $salt ] )
     * crypt() will return a hashed string using the standard Unix DES-based algorithm or alternative algorithms that may be available on the system.
     * Parameters

        str
        The string to be hashed.

        Caution
        Using the CRYPT_BLOWFISH algorithm, will result in the str parameter being truncated to a maximum length of 72 characters.
        salt
        An optional salt string to base the hashing on. If not provided, the behaviour is defined by the algorithm implementation and can lead to unexpected results.

     *
     * Return Values

        Returns the hashed string or a string that is shorter than 13 characters and is guaranteed to differ from the salt on failure.
     * */

    /*
     * base64_encode()
     * base64_encode — Encodes data with MIME base64
     * string base64_encode ( string $data )
     * Parameters ?

        data
        The data to encode.
     *
     * Return Values ?

        The encoded data, as a string or FALSE on failure.
     * */

}