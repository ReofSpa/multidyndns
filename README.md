# multidyndns
Update multiple DynDNS entries at once (incl. IPv6)
# Background
There were two issues I had which I liked to solve.
1. Synology provides a DynDNS update module, but none of the providers but Synology themselves are supported to use IPv6. Even when adding a custom one, there is no possibility to use, because no placeholder is provided.
2. Some of the DynDNS providers to not support IPv4 and IPv6 update in one query, you have to do two. But my FritzBox only supports one query.
# Requirements
For the IPv6 support on your Synology NAS
1. A Web Station must be running on your NAS (most probably you have that running because it's required to get a Let's Encrypt certificate).
2. Your IPv4 DynDNS query should be up and running (proof of concept).
3. You should know the https query with all required attributes for your DynDNS provider.
4. You MUST run this script on the NAS for this feature. It will fetch the IPv6 address from the machine it is running on!
For multi DynDNS support
1. You need a web server
   - Preferably outside your local network to ensure security (https connection)
   - https connections will fail unless you run a local DNS server which assigns a local IP to the domain name
   - Using https connections with IP address instead of hostname will fail due to certifications not matching
2. Your IP DynDNS query should be up and running (proof of concept).
3. You should know the https query with all required attributes for your DynDNS provider.
4. Your original DynDNS query must not include pipes "|" or "%7C" because they are used as query delimiters.
# Setup
1. Just copy the files into a directory on your web server.
2. Make sure to password protect the directory.
   - For Synology feature: The standard Web Station on the Synology NAS does not support this feature. You may enable a security feature in the script (define the internal IPv4 address ($sOwnIP) and enable the check ($bSec)
# Usage
The url should start according to the place you copied the files.

`https://www.example.com/dyndns/multiupdate.php?`

Now, add all DynDNS queries you like to execute after the question mark and separate them with a pipe.

`https://<username>:<pass>@www.example.com/dyndns/multiupdate.php?https://nobody:pasword123@carol.selfhost.de/nic/update?myip=<ipaddr>&host=<domain>|https://nobody:pasword123@carol.selfhost.de/nic/update?myip=<ip6addr>&host=<domain>`

This is an example for selfhost.de executed from a FritzBox. Remember that you cannot use the same placeholders for username and password because your password protection and the one from the DynDNS provider might differ.
If you want to update the IPv6 for a Synology NAS, just omit the IP address and let the parameter be the last one in every respective query.

`http://192.168.178.2/dyndns/multiupdate.php?https://__USERNAME__:__PASSWORD__@carol.selfhost.de/nic/update?myip=__MYIP__&host=__HOSTNAME__|https://__USERNAME__:__PASSWORD__@carol.selfhost.de/nic/update?host=__HOSTNAME__&myip=`

The script just detects the equal sign at the very end of the query and adds the IPv6 address.
Btw, on the Synology NAS it shows the update partly as failed. No idea why, but still it works. Maybe it expects a certain reply. If you have an idea, kindly give me a hint.
# Limitations
* The script does only minor checks on validity, so use it at own's risk (I am not responsible for any issues caused by it).
* I am not a professional programmer. Code might be ugly or strange to some extent, but it works (at least for me).
* If you work with IPv6, make sure you understand the difference between IPv4 (NAT concept) vs. IPv6 (direct address), so running a web server behind the router has the same IPv4 but a different IPv6 address.