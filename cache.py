# Program to test whether the cash works or not 
# https://www.digitalocean.com/community/tutorials/docker-explained-how-to-create-docker-containers-running-memcached

# Example: python cache.py [port] [key] [value]
##RUN: python cache.py 45001 my_test_key test_value

# Return: Value for my_test_key set

# See if the key is set:
##RUN: python cache.py 45001 my_test_key

# Return: Value for my_test_key is test_value.


# Import python-memcache and sys for arguments
import memcache
import sys

# Set address to access the Memcached instance
addr = 'localhost'

# Get number of arguments
# Expected format: python cache.py [memcached port] [key] [value]
len_argv = len(sys.argv)

# At least the port number and a key must be supplied
if len_argv < 3:
    sys.exit("Not enough arguments.")

# Port is supplied and a key is supplied - let's connect!
port  = sys.argv[1]
cache = memcache.Client(["{0}:{1}".format(addr, port)])

# Get the key
key   = str(sys.argv[2])

# If a value is also supplied, set the key-value pair
if len_argv == 4:

    value = str(sys.argv[3])    
    cache.set(key, value)

    print("Value for",key," set!")

# If a value is not supplied, return the value for the key
else:

    value = cache.get(key)

    print ("Value for", key," is", value) 