#!/usr/bin/python

import sys

import populartimes


print(populartimes.get("AIzaSyCOesF8JpkKVCeiHbRfyH867wmZ63lMPGE", ["cafe", "park", "bar", "library", "meal", "store", "gym"], (float(sys.argv[1]), float(sys.argv[2])), (float(sys.argv[3]), float(sys.argv[4]))))

