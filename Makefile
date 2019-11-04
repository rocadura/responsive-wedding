#
# Tools
#
CP      = cp
SCP	= scp
SSH     = ssh

#
# Local directories
#

MKFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
MKFILE_DIR := $(dir $(MKFILE_PATH))
BASEDIR :=$(patsubst %/,%,$(MKFILE_DIR))
CSSDIR  :=$(BASEDIR)/css
FONTSDIR:=$(BASEDIR)/fonts
HTMLDIR :=$(BASEDIR)/html
IMGDIR  :=$(BASEDIR)/img
JSDIR   :=$(BASEDIR)/js
PHPDIR  :=$(BASEDIR)/php
SQLDIR  :=$(BASEDIR)/sql

#
# Make copy directories
#
MKBASEDIR   :=/opt/lampp/htdocs/html
MKCSSDIR    :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(CSSDIR))
MKFONTSDIR  :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(FONTSDIR))
MKHTMLDIR   :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(HTMLDIR))
MKIMGDIR    :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(IMGDIR))
MKJSDIR     :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(JSDIR))
MKPHPDIR    :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(PHPDIR))
MKSQLDIR    :=$(patsubst $(BASEDIR)/%, $(MKBASEDIR)/%, $(SQLDIR))

#
# Server credentials. Server upload via SSH
#
# SERVERUSER :=
# SERVERDOM  :=


#
# Server directories
#
# SVDIR       :=/home/user/html
# SVCSSDIR    :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(CSSDIR))
# SVFONTSDIR  :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(FONTSDIR))
# SVHTMLDIR   :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(HTMLDIR))
# SVIMGDIR    :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(IMGDIR))
# SVJSDIR     :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(JSDIR))
# SVPHPDIR    :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(PHPDIR))
# SVSQLDIR    :=$(patsubst $(BASEDIR)/%, $(SVDIR)/%, $(SQLDIR))


#
# Source files
#

BASESRCS   :=$(wildcard $(BASEDIR)/*) # missing -> .htaccess!
CSSSRCS    :=$(wildcard $(CSSDIR)/*.css)
FONTSSRCS  :=$(wildcard $(FONTSDIR)/*.ttf)
HTMLSRCS   :=$(wildcard $(HTMLDIR)/*.html)
IMGSRCS    :=$(wildcard $(IMGDIR)/*.jpg)
PNGSRCS    :=$(wildcard $(IMGDIR)/*.png)
JSSRCS     :=$(wildcard $(JSDIR)/*.js)
PHPSRCS    :=$(wildcard $(PHPDIR)/*.php)
SQLSRCS    :=$(wildcard $(SQLDIR)/*)


#
# Target files
#
SVBASESRCS   :=$(patsubst $(BASEDIR)/index.%,$(MKBASEDIR)/index.%,$(BASESRCS))
SVCSSSRCS    :=$(patsubst $(BASEDIR)/%.css,$(MKBASEDIR)/%.css,$(CSSSRCS))
SVFONTSSRCS    :=$(patsubst $(BASEDIR)/%.ttf,$(MKBASEDIR)/%.ttf,$(FONTSSRCS))
SVHTMLSRCS   :=$(patsubst $(BASEDIR)/%.html,$(MKBASEDIR)/%.html,$(HTMLSRCS))
SVIMGSRCS    :=$(patsubst $(BASEDIR)/%.jpg,$(MKBASEDIR)/%.jpg,$(IMGSRCS))
SVIMGSRCS    :=$(patsubst $(BASEDIR)/%.png,$(MKBASEDIR)/%.png,$(PNGSRCS))
SVJSSRCS     :=$(patsubst $(BASEDIR)/%.js,$(MKBASEDIR)/%.js,$(JSSRCS))
SVPHPSRCS    :=$(patsubst $(BASEDIR)/%.php,$(MKBASEDIR)/%.php,$(PHPSRCS))
SVSQLSRCS    :=$(patsubst $(BASEDIR)/%.sql,$(MKBASEDIR)/%.sql,$(SQLSRCS))


.PHONY: all clean clobber dirs

all: srcs

srcs:  $(SVBASESRCS) $(SVCSSSRCS) $(SVFONTSSRCS) $(SVHTMLSRCS) $(SVIMGSRCS) $(SVJSSRCS) $(SVPHPSRCS) $(SVSQLSRSCS)


$(MKBASEDIR)/%: $(BASEDIR)/%
	$(CP) $< $@
#	$(SCP) $< $(SERVERUSER)@$(SERVERDOM):$(patsubst $(MKBASEDIR)/%,$(SVDIR)/%,$@)


clean: # local host
	rm -r $(MKBASEDIR)/*


clobber: clean # Recipe to delete local host and remote server dirs
#	ssh    $(SERVERUSER)@$(SERVERDOM) "rm -r $(SVDIR)/*"

dirs: # local host
	mkdir -p $(MKCSSDIR) $(MKFONTSDIR) $(MKHTMLDIR) $(MKIMGDIR) $(MKJSDIR) $(MKPHPDIR) $(MKSQLDIR)

# Recipe to create remote Server dirs
#	ssh    $(SERVERUSER)@$(SERVERDOM) "mkdir -p $(SVCSSDIR) $(SVFONTSDIR) $(SVHTMLDIR) $(SVIMGDIR) $(SVJSDIR) $(SVPHPDIR) $(SVSQLDIR)"
