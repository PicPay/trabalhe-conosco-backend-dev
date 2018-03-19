package com.kklein.bean;

public interface Bean {
	<T extends Bean> T getObjectClone();
	<T extends Bean> void setObjectClone(T objeto);
	
	Bean clone();
}
