package com.kklein.bean;

import java.util.function.Consumer;
import java.util.function.Predicate;

public abstract class AbstractJpaBean implements Cloneable, Bean {
	protected transient Bean objectClone;

	public Object copy(final Object origem){
		return this;
	}

	@Override
	public AbstractJpaBean clone() {
		try {
			return (AbstractJpaBean) super.clone();
		} catch (final CloneNotSupportedException e) {
			throw new RuntimeException(e);
		}
	}


	@SuppressWarnings("unchecked")
	public <T extends Bean> T getObjectClone() {
		return (T) objectClone;
	}

	public <T extends Bean> void setObjectClone(final T objeto) {
		this.objectClone = objeto;
	}
	
	@SafeVarargs
	@SuppressWarnings("unchecked")
	public final <T extends Bean> T update(final Consumer<T>... fns) {
		final T clone = (T) clone();
		
		for (Consumer<T> fn : fns)
			fn.accept(clone);
		
		return clone;
	}
	
	@SafeVarargs
	@SuppressWarnings("unchecked")
	public final <T extends Bean> T updateIf(final Predicate<T> predicate, final Consumer<T>... fns) {
		return predicate.test((T) this) ? update(fns) : (T) this;
	}
}
